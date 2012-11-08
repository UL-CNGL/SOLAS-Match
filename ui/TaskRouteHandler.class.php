<?php

class TaskRouteHandler
{
    public function init()
    {
        $app = Slim::getInstance();
        $middleware = new Middleware();

        $app->get('/tasks/archive/p/:page_no', array($this, 'archivedTasks')
        )->name('archived-tasks');

        $app->get('/tasks/active/p/:page_no', array($this, 'activeTasks')
        )->name('active-tasks');        

        $app->get('/task/id/:task_id/download-task-latest-file/', array($middleware, 'authUserForOrgTask'),
        array($this, 'downloadTaskLatestVersion'))->name('download-task-latest-version');
        
        $app->get('/task/id/:task_id/mark-archived/', array($middleware, 'authUserForOrgTask'),
        array($this, 'archiveTask'))->name('archive-task');

        $app->get('/task/id/:task_id/download-file-user/', array($middleware, 'authenticateUserForTask'),
        array($this, 'downloadTask'))->name('download-task');

        $app->get('/task/claim/:task_id', array($middleware, 'authenticateUserForTask'),
        array($this, 'taskClaim'))->name('task-claim-page');

        $app->get('/task/id/:task_id/claimed', array($middleware, 'authenticateUserForTask'),
        array($this, 'taskClaimed'))->name('task-claimed');

        $app->post('/claim-task', array($this, 'claimTask'))->name('claim-task');

        $app->get('/task/id/:task_id/download-file/v/:version/', array($middleware, 'authUserIsLoggedIn'), 
        array($middleware, 'authUserForTaskDownload'), array($this, 'downloadTaskVersion'))->name('download-task-version');

        $app->get('/task/id/:task_id/download-preview/', array($middleware, 'authenticateUserForTask'),
        array($this, 'downloadTaskPreview'))->name('download-task-preview');

        $app->get('/task/id/:task_id/', array($middleware, 'authenticateUserForTask'),
        array($this, 'task'))->name('task');

        $app->get('/task/id/:task_id/uploaded/', array($middleware, 'authenticateUserForTask'),
        array($this, 'taskUploaded'))->name('task-uploaded');

        $app->get('/task/describe/:task_id/', array($middleware, 'authenticateUserForTask'), 
        array($this, 'taskDescribe'))->via('GET','POST')->name('task-describe');
        
        $app->get('/task/alter/:task_id/', array($middleware, 'authUserForOrgTask'), 
        array($this, 'taskAlter'))->via('POST')->name('task-alter');

        $app->get('/task/view/:task_id/', array($middleware, 'authUserForOrgTask'),
        array($this, 'taskView'))->via("POST")->name('task-view');

        $app->get('/task/:task_id/uploaded-edit/', array($middleware, 'authenticateUserForTask'),
        array($this, 'taskUploadedEdit'))->name('task-uploaded-edit');

        $app->get('/task/:task_id/upload-edited/', array($middleware, 'authenticateUserForTask'), 
        array($this, 'taskUploadEdited'))->via('POST')->name('task-upload-edited');

        $app->get('/task/upload/:org_id', array($middleware, 'authUserForOrg'), 
        array($this, 'taskUpload'))->via('GET','POST')->name('task-upload');
    }

    public function archivedTasks($page_no)
    {
        $app = Slim::getInstance();
        $client = new APIClient();      
        $user_id = UserSession::getCurrentUserID();
        
        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request, HTTP_Request2::METHOD_GET);
        $user = $client->cast('User', $response);

        if (!is_object($user)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        } 
        
        $archived_tasks = array();
        $request = APIClient::API_VERSION."/users/$user_id/archived_tasks";
        $response = $client->call($request, HTTP_Request2::METHOD_GET, null, array('limit' => 10 )); 
        
        if($response) {
            foreach($response as $stdObject) {
                $archived_tasks[] = $client->cast('Task', $stdObject);
            }
        }        

        $tasks_per_page = 10;
        $total_pages = ceil(count($archived_tasks) / $tasks_per_page);
        
        if($page_no < 1) {
            $page_no = 1;
        } elseif($page_no > $total_pages) {
            $page_no = $total_pages;
        }   
        
        $top = (($page_no - 1) * $tasks_per_page);
        $bottom = $top + $tasks_per_page - 1;
        
        if($top < 0) {
            $top = 0;
        } elseif($top > count($archived_tasks) - 1) {
            $top = count($archived_tasks) - 1; 
        }   
        
        if($bottom < 0) {
            $bottom = 0;
        } elseif($bottom > count($archived_tasks) - 1) {
            $bottom = count($archived_tasks) - 1; 
        }   
        
        $app->view()->setData('archived_tasks', $archived_tasks);
        $app->view()->appendData(array(
                                    'page_no' => $page_no,
                                    'last' => $total_pages,
                                    'top' => $top,
                                    'bottom' => $bottom
        ));
        $app->render('archived-tasks.tpl');
    }

    public function activeTasks($page_no)
    {
        $app = Slim::getInstance();
        $client = new APIClient();

        $user_id = UserSession::getCurrentUserID();
        if (is_null($user_id)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }

        $activeTasks = array();
        $request = APIClient::API_VERSION."/users/$user_id/tasks";
        $response = $client->call($request);
        
        if($response) {
            foreach($response as $stdObject) {
                $activeTasks[] = $client->cast('Task', $stdObject);
            }
        }
        
        $tasks_per_page = 10;
        $total_pages = ceil(count($activeTasks) / $tasks_per_page);
        
        if($page_no < 1) {
            $page_no = 1;
        } elseif($page_no > $total_pages) {
            $page_no = $total_pages;
        }   
        
        $top = (($page_no - 1) * $tasks_per_page);
        $bottom = $top + $tasks_per_page - 1;
        
        if($top < 0) {
            $top = 0;
        } elseif($top > count($activeTasks) - 1) {
            $top = count($activeTasks) - 1; 
        }   
        
        if($bottom < 0) {
            $bottom = 0;
        } elseif($bottom > count($activeTasks) - 1) {
            $bottom = count($activeTasks) - 1;
        }
        
        $app->view()->setData('active_tasks', $activeTasks);
        $app->view()->appendData(array(
                        'page_no' => $page_no,
                        'last' => $total_pages,
                        'top' => $top,
                        'bottom' => $bottom,
                        'current_page' => 'active-tasks'
        ));
        
        $app->render('active-tasks.tpl');
    }

    public function downloadTaskLatestVersion($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);
        $task = $client->cast('Task', $response);
    
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }

        $user_id = UserSession::getCurrentUserID();
        
        if (is_null($user_id)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   
        
        $latest_version = TaskFile::getLatestFileVersion($task);    //wait for API support
        $app->redirect($app->urlFor('download-task-version', array(
                'task_id' => $task_id,
                'version' => $latest_version
        )));
    }

    public function archiveTask($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);
        $task = $client->cast('Task', $response);
        
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }   
        $user_id = UserSession::getCurrentUserID();
        
        if (is_null($user_id)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   
        
        Notify::sendEmailNotifications($task, NotificationTypes::Archive);
        
        $request = APIClient::API_VERSION."/tasks/archiveTask/$task_id";
        $response = $client->call($request, HTTP_Request2::METHOD_PUT);        
        
        $app->redirect($ref = $app->request()->getReferrer());
    }

    public function downloadTask($task_id)
    {
        
        $app = Slim::getInstance();
        /*
        $client = new APIClient();
        
        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);
        $task = $client->cast('Task', $response);
        
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $user_id = UserSession::getCurrentUserID();
        
        if (is_null($user_id)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }
        */
        
        if (Middleware::authUserIsLoggedIn()) {            
        
        
            $app->redirect($app->urlFor('download-task-version', array(
                    'task_id' => $task_id,
                    'version' => 0
            )));
        }
    }

    /*
     *  Claim a task after downloading it
     */
    public function taskClaim($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);
        $task = $client->cast('Task', $response);

        if(!is_object($task)) {
            header ('HTTP/1.0 404 Not Found');
            die;
        }
        $user_id = UserSession::getCurrentUserID();
        
        if (is_null($user_id)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }
        $app->view()->setData('task', $task);
        
        $app->render('task.claim.tpl');
    }

    public function taskClaimed($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);

        $task = $client->cast('Task', $response);
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }   
        $user_id = UserSession::getCurrentUserID();

        if (is_null($user_id)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   
        $app->view()->setData('task', $task);
        $app->render('task.claimed.tpl');
    }

    public function claimTask()
    {
        $app = Slim::getInstance();
        $client = new APIClient();

        $task_id = $app->request()->post('task_id');
        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);
        $task = $client->cast('Task', $response);
        
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }   
       
        $user_id = UserSession::getCurrentUserID();
        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request);
        $current_user = $client->cast('User', $response); 
        
        if (!is_object($current_user)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   

        $request = APIClient::API_VERSION."/users/$user_id/tasks";
        $response = $client->call($request, HTTP_Request2::METHOD_POST, $task);        

        Notify::notifyUserClaimedTask($current_user, $task);
        Notify::sendEmailNotifications($task, NotificationTypes::Claim);
        
        $app->redirect($app->urlFor('task-claimed', array(
                'task_id' => $task_id
        )));
    }

    public function downloadTaskVersion($task_id, $version)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);        
        
        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request);
        $user = $client->cast('User', $response);
        
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }           
        
        if (!is_object($user)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   
        
        $task_file_info         = TaskFile::getTaskFileInfo($task, $version);
         
        if (empty($task_file_info)) {
            throw new Exception("Task file info not set for.");
        }   
        
        $absolute_file_path     = Upload::absoluteFilePathForUpload($task, $version, $task_file_info['filename']);
        $file_content_type      = $task_file_info['content_type'];
        TaskFile::logFileDownload($task, $version);
        IO::downloadFile($absolute_file_path, $file_content_type);
    }

    public function downloadTaskPreview($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();
        
        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request);
        $user = $client->cast('User', $response);        

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response); 
        
        
        if (!is_object($user)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   
        
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }   
        
        $app->view()->setData('task', $task);
        $app->render('task.download-preview.tpl');
    }

    public function task($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);
        
        if (!is_object($task)) {
            header('HTTP/1.0 404 Not Found');
            die;
        }

        $request = APIClient::API_VERSION."/orgs/{$task->getOrganisationId()}";
        $response = $client->call($request); 
        $org = $client->cast('Organisation', $response);
        
        $app->view()->setData('task', $task);
        $app->view()->appendData(array('org' => $org));
        
        if ($task_file_info = TaskFile::getTaskFileInfo($task)) {
            $app->view()->appendData(array(
                'task_file_info' => $task_file_info,
                'latest_version' => TaskFile::getLatestFileVersion($task)
            ));
        }
        
        $task_file_info = TaskFile::getTaskFileInfo($task, 0);
        $file_path = dirname(Upload::absoluteFilePathForUpload($task, 0, $task_file_info['filename']));
        $appPos = strrpos($file_path, "app");
        $file_path = "http://".$_SERVER["HTTP_HOST"].$app->urlFor('home').
                substr($file_path, $appPos).'/'.$task_file_info['filename'];
        $app->view()->appendData(array(
            'file_preview_path' => $file_path,
            'file_name' => $task_file_info['filename']
        )); 
        
        $request = APIClient::API_VERSION."/tasks/$task_id/claimed";
        $taskClaimed = $client->call($request, HTTP_Request2::METHOD_GET);
        
        if ($taskClaimed) {
            $app->view()->appendData(array(
                'task_is_claimed' => true
            ));
            
            $request = APIClient::API_VERSION."/users/$user_id";
            $user = $client->call($request, HTTP_Request2::METHOD_GET); 
            
            if ($user) {                
                $request = APIClient::API_VERSION."/tasks/{$task->getTaskId()}/claimed";
                $userClaimedTask = $client->call($request, HTTP_Request2::METHOD_GET, null, array('userID' => $user_id));  
                
                if ($userClaimedTask) {
                    $app->view()->appendData(array(
                        'this_user_has_claimed_this_task' => true
                    ));

                    $request = APIClient::API_VERSION."/tasks/{$task->getTaskId()}/version";
                    $response = $client->call($request, HTTP_Request2::METHOD_GET);
                    $taskVersion = $response->version;
                    
                    if($taskVersion > 0) {
                        $app->view()->appendData(array(
                            'file_previously_uploaded' => true
                        ));                        
                    }
                }
            }
        }
        
        if(UserRouteHandler::isLoggedIn()) {
            $_SESSION['previous_page'] = 'task';
            $_SESSION['old_page_vars'] = array("task_id" => $task_id);
        }
        
        $app->view()->appendData(array(
                'max_file_size' => Upload::maxFileSizeMB(),
                'body_class'    => 'task_page'
        ));
        
        $app->render('task.tpl');
    }

    public function taskUploaded($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);
       
        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request, HTTP_Request2::METHOD_GET);
        $user = $client->cast('User', $response);        
        
        if (!is_object($user)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   
        
        $org_id = $task->getOrganisationId();
        $app->view()->appendData(array(
                'org_id' => $org_id
        ));     
        
        $app->render('task.uploaded.tpl');
    }

    public function taskDescribe($task_id)
    {
    	$app = Slim::getInstance();
	$client = new APIClient();
        
    	$error          = null;
    	$title_err      = null;
	$word_count_err = null;
        
        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);

    	if (!is_object($task)) {
            $app->notFound();
        }

        if (isValidPost($app)) {
            $post = (object)$app->request()->post();

            if($post->title != '') {
                $task->setTitle($post->title);
            } else {
                $title_err = "Title cannot be empty";
            }

            if(ctype_digit($post->word_count)) {
                $task->setWordCount($post->word_count);
            } else if($post->word_count == '') {
                $task->setWordCount($post->word_count);
            }
            
            if(is_null($word_count_err) && is_null($title_err))
            {
                if (!empty($post->source)) {
                    $source_id = Languages::saveLanguage($post->source);
                    $task->setSourceId($source_id);
                }

                if($post->impact != '') {
                    $task->setImpact($post->impact);
                }

                if($post->reference != '' && $post->reference != "http://") {
                    $task->setReferencePage($post->reference);
                }
        
                if(isset($post->sourceCountry)&&$post->sourceCountry != '') {
                    $task->setSourceCountryCode($post->sourceCountry);
                }

                if(isset($post->targetCountry)&&$post->targetCountry != '') {
                    $task->setTargetCountryCode($post->targetCountry);
                }

                $tags = $post->tags;
                if(is_null($tags)) {
                    $tags = '';
                }

                $task_file_info = TaskFile::getTaskFileInfo($task);
                $filename = $task_file_info['filename'];
                if($pos = strrpos($filename, '.')) {
                    $extension = substr($filename, $pos + 1);
                    $extension = strtolower($extension);
                    $tags .= " $extension";
                }
    
                $task->setTags(Tags::separateTags($tags));            
                
                $language_list = array();
                $country_list = array();
                $target_count = 0;
                $target_val = $app->request()->post("target_$target_count");
                $targetCountry_val = $app->request()->post("targetCountry_$target_count");
                while(isset($target_val)&&isset($targetCountry_val)) {
                    $temp=null;
                    if(!in_array(($temp=array("lang"=>$target_val,"country"=>$targetCountry_val)), $language_list)) {
                        $language_list[] = $temp;
                    }
                    $target_count += 1;
                    $target_val = $app->request()->post("target_$target_count");
                    $targetCountry_val = $app->request()->post("targetCountry_$target_count");
                }
    
                if(count($language_list) > 1) {
                    foreach($language_list as $language) {
                        if($language == $language_list[0]) {   //if it is the first language add it to this task
                            $target_id = Languages::saveLanguage($language_list[0]['lang']);
                            $task->setTargetId($target_id);
                            $task->setTargetCountryCode($language['country']);
                            $request = APIClient::API_VERSION."/tasks/$task_id";
                            $response = $client->call($request, HTTP_Request2::METHOD_PUT, $task);
                        } else {
                            $language_id = Languages::saveLanguage($language['lang']);                            
                            $request = APIClient::API_VERSION."/tasks/addTarget/$language_id/{$language['country']}";
                            $response = $client->call($request, HTTP_Request2::METHOD_POST, $task);
                        }
                    }
                } else {
                    $target_id = Languages::saveLanguage($language_list[0]['lang']);
                    $task->setTargetId($target_id);
                    $task->setTargetCountryCode($language_list[0]['country']);
                    
                    $request = APIClient::API_VERSION."/tasks/$task_id";
                    $response = $client->call($request, HTTP_Request2::METHOD_PUT, $task);
                }
    
                $app->redirect($app->urlFor('task-uploaded', array('task_id' => $task_id)));
            }
        }
        $language_list = Languages::getLanguageList();
        $countries= Languages::getCountryList();
        $extra_scripts = "
        <script language='javascript'>
        
        var fields = 0;
        var MAX_FIELDS = 10; 
        var isRemoveButtonHidden = true;
        
        function addInput() {
        
            if(isRemoveButtonHidden) {
                document.getElementById('removeBottomTargetBtn').style.visibility = 'visible';
                isRemoveButtonHidden = false;
            }
        
            if (fields < MAX_FIELDS) {
                
                document.getElementById('text' + fields).innerHTML += '<label for=\"target_' + (fields + 1) + '\"><b>To language</b></label>';
                document.getElementById('text' + fields).innerHTML += '<select name=\"target_' + (fields + 1) + '\" id=\"target_' + (fields + 1) + '\">';
                document.getElementById('text' + fields).innerHTML += '</select>';  
                
                var sel = document.getElementById('target_' + (fields + 1));
                var options = sel.options;
                var langs = ".json_encode($language_list).";
                    
                for (language in langs) {
                    var option = document.createElement('OPTION');
                    option.appendChild(document.createTextNode(langs[language][0]));
                    option.setAttribute('value', langs[language][0]);//should be 1 but requires changes to php and sql.
                    sel.appendChild(option);
                }
                
                sel.options.selectedIndex=0;
                document.getElementById('text' + fields).innerHTML += '<select name=\"targetCountry_' + (fields + 1) + '\" id=\"targetCountry_' + (fields + 1) + '\">';
                document.getElementById('text' + fields).innerHTML += '</select>';
                document.getElementById('text' + fields).innerHTML += '<p style\=\"margin-bottom:10px;\"></p>';                    
                
                sel = document.getElementById('targetCountry_' + (fields + 1));
                options = sel.options;                
                var countries =".json_encode($countries).";
                    
                for (country in countries) {
                    var option = document.createElement('OPTION');
                    option.appendChild(document.createTextNode(countries[country][0]));
                    option.setAttribute('value', countries[country][1]);
                    sel.appendChild(option);
                }
                
                sel.options.selectedIndex=0;                
                fields++;                
            }
            
            if(fields == MAX_FIELDS) {
                document.getElementById('alertinfo').style.display = 'block';
                     document.getElementById('addMoreTargetsBtn').style.visibility = 'hidden';
            }            
        } 
        </script>        
        <script language='javascript'> 
                        
            function removeInput() {  
            
                var id = fields-1;
                document.getElementById('text' + id).innerHTML = '';   
                
                if(fields == MAX_FIELDS) {
                    document.getElementById('addMoreTargetsBtn').style.visibility = 'visible';
                    document.getElementById('alertinfo').style.display = 'none';
                }
                
                fields--;
                
                if(fields == 0) {
                    document.getElementById('removeBottomTargetBtn').style.visibility = 'hidden';
                    isRemoveButtonHidden = true;
                } 
            }            
        </script>";
        
        $countries= Languages::getCountryList();
        $app->view()->appendData(array(
            'error'             => $error,
            'title_error'       => $title_err,
            'word_count_err'    => $word_count_err,
            'url_task_describe' => $app->urlFor('task-describe', array('task_id' => $task_id)),
            'task'              => $task,
            'languages'         => $language_list,
            'countries'         => $countries,
            'extra_scripts'     => $extra_scripts
        ));
        
        $app->render('task.describe.tpl');
    }

    public function taskAlter($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $word_count_err = null;

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);
        
        $app->view()->setData('task', $task);
        
        if(isValidPost($app)) {
            $post = (object)$app->request()->post();
            
            if($post->title != '') {
                $task->setTitle($post->title);
            }
            
            if($post->impact != '') {
                $task->setImpact($post->impact);
            }
            
            if($post->reference != '' && $post->reference != 'http://') {
                $task->setReferencePage($post->reference);
            }
            
            if($post->source != '') {
                $task->setSourceId($post->source);
            }
            
            if($post->target != '') {
                $task->setTargetId($post->target);
            }   
             
            if($post->sourceCountry != '') {
                $task->setSourceCountryCode($post->sourceCountry);
            }   
             
            if($post->targetCountry != '') {
                $task->setTargetCountryCode($post->targetCountry);
            }   
              
            if($post->tags != '') {
                $task->setTags(Tags::separateTags($post->tags));
            }
            

            if(ctype_digit($post->word_count)) {
                $task->setWordCount($post->word_count);                
                $request = APIClient::API_VERSION."/tasks/$task_id";
                $response = $client->call($request, HTTP_Request2::METHOD_PUT, $task);
                $app->redirect($app->urlFor("task-view", array("task_id" => $task_id)));
            } else if($post->word_count != '') {
                $word_count_err = "Word Count must be numeric";
            } else {
                $word_count_err = "Word Count cannot be blank";
            }
            

        }
         
        $languages = Languages::getLanguageList();
        $countries = Languages::getCountryList();
        
        $tags = $task->getTags();
        $tag_list = '';
        if($tags!=null){
            foreach($tags as $tag) {
                $tag_list .= $tag . ' ';
            }
        }
        
        $app->view()->appendData(array(
                              'languages'       => $languages,
                              'countries'       => $countries,
                              'tag_list'        => $tag_list,
                              'word_count_err'  => $word_count_err,
        ));
        
        $app->render('task.alter.tpl');
    }

    public function taskView($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);        
        $app->view()->setData('task', $task);

        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request);
        $user = $client->cast('User', $response);         
         
        if($app->request()->isPost()) {
            $post = (object) $app->request()->post();
            
            if(isset($post->notify) && $post->notify == "true") {
                $request = APIClient::API_VERSION."/users/$user_id/tracked_tasks/{$task->getTaskId()}";
                $userTrackTask = $client->call($request, HTTP_Request2::METHOD_PUT);
                
                if($userTrackTask) {
                    $app->flashNow("success", 
                            "You are now tracking this task and will receive email notifications
                            when its status changes.");
                } else {
                    $app->flashNow("error", "Unable to register for notifications for this task.");
                }   
            } else {

                $request = APIClient::API_VERSION."/users/$user_id/tracked_tasks/{$task->getTaskId()}";
                $userIgnoreTask = $client->call($request, HTTP_Request2::METHOD_DELETE);
                
                if($response) {
                    $app->flashNow("success", 
                            "You are no longer tracking this task and will receive no
                            further emails."
                    );
                } else {
                    $app->flashNow("error", "Unable to unregister for this notification.");
                }   
            }   
        }   
        
        $request = APIClient::API_VERSION."/users/subscribedToTask/{$user->getUserId()}/$task_id";
        $registered = $client->call($request);         

        $request = APIClient::API_VERSION."/orgs/{$task->getOrganisationId()}";
        $response = $client->call($request);     
        $org = $client->cast('Organisation', $response);

        $app->view()->appendData(array(
                                 'org' => $org,
                                 'registered' => $registered
        ));
        
        $app->render('task.view.tpl');
    }

    public function taskUploadedEdit($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);
        $org_id = $task->getOrganisationId();

        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request);
        $user = $client->cast('User', $response);
        
        if (!is_object($user)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }   
        
        $request = APIClient::API_VERSION."/orgs/{$task->getOrganisationId()}";
        $response = $client->call($request); 
        $org = $client->cast('Organisation', $response);
        $org_name = $org->getName();
        
        $tip_selector = new TipSelector();
        $tip = $tip_selector->selectTip();
        
        $app->view()->appendData(array(
                'org_name' => $org_name,
                'tip' => $tip 
        ));                     
        
        $app->render('task.uploaded-edit.tpl');
    }

    public function taskUploadEdited($task_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();

        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request);
        $currentUser = $client->cast('User', $response);
        
        if (!is_object($currentUser)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }

        $request = APIClient::API_VERSION."/tasks/$task_id";
        $response = $client->call($request);     
        $task = $client->cast('Task', $response);
        
        if (!is_object($task)) {
            $app->notFound();
        }
        
        $field_name = 'edited_file';
        $error_message = null;
        
        try {
            Upload::validateFileHasBeenSuccessfullyUploaded($field_name);
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }
        
        if (is_null($error_message)) {
            try {
                Upload::saveSubmittedFile($field_name, $task, $currentUser->getUserId());
            } catch (Exception  $e) {
                $error_message = 'File error: ' . $e->getMessage();
            }
        }
        
        if (is_null($error_message)) {
            Notify::sendEmailNotifications($task, NotificationTypes::Upload);
            $app->redirect($app->urlFor('task-uploaded-edit', array('task_id' => $task_id)));
        } else {
            $app->flash("error", $error_message);
            $app->redirect($app->urlFor("task", array("task_id" => $task_id)));
        }
    }

    public function taskUpload($org_id)
    {
        $app = Slim::getInstance();
        $client = new APIClient();
        $user_id = UserSession::getCurrentUserID();        

        $error_message = null;
        $field_name = 'new_task_file';
        
        $request = APIClient::API_VERSION."/users/$user_id";
        $response = $client->call($request);
        $current_user = $client->cast('User', $response);
        
        if (!is_object($current_user)) {
            $app->flash('error', 'Login required to access page');
            $app->redirect($app->urlFor('login'));
        }
        
        if ($app->request()->isPost()) {
            
            $upload_error = false;
            try {
                Upload::validateFileHasBeenSuccessfullyUploaded($field_name);
            } catch (Exception $e) {
                $upload_error = true;
                $error_message = $e->getMessage();
            }
            
            if (!$upload_error) {
                
                $request = APIClient::API_VERSION."/tasks";
                $response = $client->call($request, HTTP_Request2::METHOD_POST, new Task(array(
                        'organisation_id' => $org_id,
                        'title' => $_FILES[$field_name]['name']
                )));
                
                $task = $client->cast('Task', $response);

                try {
                    Upload::saveSubmittedFile($field_name, $task, $current_user->getUserId());
                } catch (Exception  $e) {
                    $upload_error = true;
                    $error_message = 'File error: ' . $e->getMessage();
                }
            }
            
            if (!$upload_error) {
                $app->redirect($app->urlFor('task-describe', array('task_id' => $task->getTaskId())));
            }
        }
        
        if (!is_null($error_message)) {
            $app->view()->appendData(array('error' => $error_message));
        }
        $app->view()->appendData(array(
               'url_task_upload'       => $app->urlFor('task-upload', array('org_id' => $org_id)),
               'max_file_size_bytes'   => Upload::maxFileSizeBytes(),
               'max_file_size_mb'      => Upload::maxFileSizeMB(),
               'field_name'            => $field_name
        ));
        $app->render('task.upload.tpl');
    }
   
}
