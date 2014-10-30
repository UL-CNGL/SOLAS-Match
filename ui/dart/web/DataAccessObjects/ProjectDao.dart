part of SolasMatchDart;

/**
 * Class containing methods to access and modify [Project]-related data through the API.
 */
class ProjectDao
{ 
  /**
   * Calls the API to get the [Project] object corresponding to the given [id].
   * 
   * Returns a [Future] whose value will be a [Project] object with the given [id].
   */
  static Future<Project> getProject(int id)
  {
    APIHelper client = new APIHelper(".json");
    Future<Project> project = client.call("Project", 
        "v0/projects/" + id.toString(), "GET")
          .then((HttpRequest response) {
      Project pro = null;
      if (response.status < 400) {
        if (response.responseText != '') {
          Map jsonParsed = JSON.decode(response.responseText);
          pro = ModelFactory.generateProjectFromMap(jsonParsed);
        }
      } else {
        print("Error: getProject returned " + response.status.toString() + " " + response.statusText);
      }
      return pro;
    });
    return project;
  }
  
  /**
   * Calls the API to get the [Project] with the given [title].
   * 
   * Returns a [Future] whose value will be a [Project] object with the given [title].
   */
  static Future<Project> getProjectByName(String title)
  {
    print("IN DART DAO TITLE IS: $title");
    APIHelper client = new APIHelper(".json");
    Future<Project> project = client.call("Project", 
        "v0/projects/getProjectByName", "POST", title)
          .then((HttpRequest response) {
      Project pro = null;
      if (response.status < 400) {
        if (response.responseText != '') {
          Map jsonParsed = JSON.decode(response.responseText);
          pro = ModelFactory.generateProjectFromMap(jsonParsed);
        }
      } else {
        print("Error: getProject returned " + response.status.toString() + " " + response.statusText);
      }
      return pro;
    });
    return project;
  }
  
  static Future<List<Tag>> getProjectTags(int projectId)
  {
    APIHelper client = new APIHelper(".json");
    Future<List<Tag>> projTags = client.call("", "v0/projects/$projectId/tags", "GET")
      .then((HttpRequest response) {
        List<Tag> tags = new List<Tag>();
        if (response.status < 400) {
          if (response.responseText != '') {
            Map jsonParsed = JSON.decode(response.responseText);
            if (jsonParsed.length > 0) {
              jsonParsed['item'].forEach((String data) {            
                Map tag = JSON.decode(data);
                tags.add(ModelFactory.generateTagFromMap(tag));
              });
            }
          }
        } else {
          print("Error: getProject returned " + response.status.toString() + " " + response.statusText);
        }
        return tags;
      });
    return projTags;
  }
  
  /**
   * Calls the API to request that deadlines for the [Project] with id matching the given [projectId] should be
   * calculated. The API then generates an appropriate request to send to the backend.
   * 
   * Returns a [Future] whose value will be true if the API sent back a response code less than 400, otherwise
   * throws a [String] showing the response code and status text.
   */
  static Future<bool> calculateProjectDeadlines(int projectId)
  {
    APIHelper client = new APIHelper(".json");
    Future<bool> ret = client.call("", "v0/projects/$projectId/calculateDeadlines", "POST")
        .then((HttpRequest response) {
          if (response.status < 400) {
            return true;
          } else {
            throw "Error #" + response.status.toString() + " - " + response.statusText;
          }
    });
    return ret;
  }
  
  /**
   * Calls the API to create a project represented by the [Project] object [project].
   * 
   * Returns a [Future] whose value will be a [Project] object representing the created project on successful
   * completion. If a response code greater than or equal to 400 is sent back from the API a [String] is thrown
   * showing the response code and status text. 
   */
  static Future<Project> createProject(Project project)
  {
    APIHelper client = new APIHelper(".json");
    Future<Project> ret = client.call("Project", "v0/projects", "POST", JSON.encode(project))
        .then((HttpRequest response) {
          Project pro = null;
          if (response.status < 400) {
            if (response.responseText != '') {
              Map jsonParsed = JSON.decode(response.responseText);
              pro = ModelFactory.generateProjectFromMap(jsonParsed);
            }
          } else {
            throw "Error #" + response.status.toString() + " - " + response.statusText;
          }
          return pro;
        });
    return ret;
  }
  
  /**
   * Calls the API to update the project with the same id as [project].
   * 
   * Returns a [Future] whose value will be a [Project] object representing the updated project on successful
   * completion. If a response code greater than or equal to 400 is sent back from the API a [String] is thrown
   * showing the response code and status text. 
   */
    static Future<Project> updateProject(Project project)
    {
      APIHelper client = new APIHelper(".json");
      Future<Project> ret = client.call("Project", "v0/projects/${project.id}", "PUT", JSON.encode(project))
        .then((HttpRequest response) {
          Project pro = null;
          if (response.status < 400) {
            if (response.responseText != '') {
              Map jsonParsed = JSON.decode(response.responseText);
              pro = ModelFactory.generateProjectFromMap(jsonParsed);
            }
          } else {
            throw "Error #" + response.status.toString() + " - " + response.statusText;
          }
          return pro;
        });
      return ret;
    }
  
  /**
   * Calls the API to delete the project with the given [projectId].
   * 
   * Returns a [Future] whose value will be true on successful deletion of the project. If a response code
   * greater than or equal to 400 is sent back from the API a [String] is thrown showing the response code
   * and status text. 
   */
  
  static Future<bool> deleteProject(int projectId)
  {
    APIHelper client = new APIHelper(".json");
    Future<bool> ret = client.call("", "v0/projects/" + projectId.toString(), "DELETE")
        .then((HttpRequest response) {
          if (response.status < 400) {
            return true;
          } else {
            throw "Error #" + response.status.toString() + " - " + response.statusText;
          }
        });
    return ret;
  }
  
  static Future<bool> deleteProjectImage(int projectId, int orgId)
  {
    APIHelper client = new APIHelper(".json");
    return client.call("", "v0/io/projectImage/$orgId/$projectId", "DELETE")
      .then((HttpRequest response) {
        if (response.status < 400) {
          if (response.status == 200) {
            return true;
          }
        } else {
          throw "Error #" + response.status.toString() + " - " + response.statusText;
        }
      });
  }
  
  static Future<int> updateProjectWordCount(int projectId, int newWordCount)
  {
    APIHelper client = new APIHelper(".json");
    Future<int> ret = client.call("", "v0/projects/$projectId/updateWordCount/$newWordCount", "PUT")
        .then((HttpRequest response) {
          if (response.status < 400) {
            return int.parse(response.responseText, onError : (String responseText) {
              throw "Error: response text was: $responseText, could not parse as int";
            });
          } else {
            throw "Error #" + response.status.toString() + " - " + response.statusText;
          }
        });
    return ret;
  }
  
  /**
   * Calls the API to upload a source file (to be saved as [filename]) for the project with the given
   * [projectId]. [userId] is the id of the [User] uploading the file (and by extension creating the project).
   * [data] stores the file contents.
   * 
   * Returns a [Future] whose value will be true on successful uploading of the project. If a response code
   * greater than or equal to 400 is sent back from the API a [String] is thrown showing the response code
   * and status text. 
   */
  static Future<bool> uploadProjectFile(int projectId, int userId, String filename, String data)
  {
    APIHelper client = new APIHelper(".json");
    filename = Uri.encodeComponent(filename);
    Future<bool> ret = client.call("", "v0/io/upload/project/$projectId/file/$filename/$userId", "PUT", data)
        .then((HttpRequest response) {
          if (response.status < 400) {
            return true;
          } else {
            throw "Error #" + response.status.toString() + " - " + response.statusText;
          }
        });
    return ret;
  }
  
  /**
   * Calls the API to upload an image file for the project with the given [projectId]. [userId] is the id 
   * of the [User] uploading the file (and by extension creating the project).
   * [data] stores the file contents.
   * 
   * Returns a [Future] whose value will be true on successful uploading of the project. If a response code
   * greater than or equal to 400 is sent back from the API a [String] is thrown showing the response code
   * and status text. 
   */
  static Future<bool> uploadProjectImage(int projectId, int userId, String filename, String data)
    {
      APIHelper client = new APIHelper(".json");
      filename = Uri.encodeComponent(filename);
      Future<bool> ret = client.call("", "v0/io/upload/project/$projectId/image/$filename/$userId", "PUT", data)
          .then((HttpRequest response) {
            if (response.status < 400) {
              return true;
            } else {
              throw "Error #" + response.status.toString() + " - " + response.statusText;
            }
          });
      return ret;
    }
  
  /**
   * Calls the API to record that the [User] with id of [userId] is tracking the [Project] with the given 
   * [projectId], meaning that they will get email updates about it.
   * 
   * Returns a [Future] whose value will be true on successful tracking of the project. If a response code
   * greater than or equal to 400 is sent back from the API a [String] is thrown showing the response code
   * and status text. 
   */
  static Future<bool> trackProject(int projectId, int userId)
  {
    APIHelper client = new APIHelper(".json");
    Future<bool> ret = client.call("", "v0/users/$userId/projects/$projectId", "PUT")
        .then((HttpRequest response) {
          if (response.status < 400) {
            return true;
          } else {
            throw "Error #" + response.status.toString() + " - " + response.statusText;
          }
        });
    return ret;
  }
}
