function drawLines()
{
    var svg = document.getElementById("project-view");
    for (var i = 0; i < languageList.length ; i++) {
        var taskArray = languageTasks[languageList[i]];
        for (var k = 0; k < taskArray.length; k++) {
            var languageBox = $("#graph_" + languageList[i]);
            var icon = $("#task_" + taskArray[k]);
            var rect = $("#rect_" + taskArray[k]);
            var X_e = parseInt(icon.attr("x")) + parseInt(languageBox.attr("x"));
            var Y_e = parseInt(icon.attr("y")) + parseInt(languageBox.attr("y")) + (parseInt(rect.attr("height")) / 2);
            preReqList = preReqs[taskArray[k]];
            for (var j = 0; j < preReqList.length; j++) {
                var preReq = $("#task_" + preReqList[j]);
                rect = $("#rect_" + preReqList[j]);
                var X_s = parseInt(preReq.attr("x")) + parseInt(languageBox.attr("x")) + parseInt(rect.attr("width"));
                var Y_s = parseInt(preReq.attr("y")) + parseInt(languageBox.attr("y")) + parseInt(rect.attr("height")) / 2;
                var Y_m = Y_s + ((Y_e - Y_s) / 2);
                var X_m = X_s + ((X_e - X_s) / 2);
                var line = document.createElementNS('http://www.w3.org/2000/svg', "polyline");
                line.setAttribute("points", X_s + "," + Y_s + " " + X_m + "," + Y_m + " " + X_e + "," + Y_e);
                line.setAttribute("marker-mid", "url(#triangle)");
                line.setAttribute("style", 'stroke:rgb(0,0,0);stroke-width:2');
                svg.appendChild(line);
            }
        }
    }
}

function repositionElements()
{
    for (var i = 0; i < allTasks.length; i++) {
        if (preReqs[allTasks[i]].length > 0) {
            var newY = 0;
            preReqList = preReqs[allTasks[i]];
            for (var j = 0; j < preReqList.length; j++) {
                newY += $("#task_" + preReqList[j]).attr("y");
            }
            newY = newY / preReqList.length;
            document.getElementById("task_" + allTasks[i]).setAttribute("y", newY);
        }
    }
}

function prepareGraph()
{
    //repositionElements();
    drawLines();
}
