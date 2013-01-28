{include file="header.tpl"}

{assign var="task_id" value=$task->getId()}

<h1 class="page-header" align="center">
    Task - {$task->getTitle()}
</h1>

<table class="table table-striped" width="100%">
    <thead>
        <th width="25%">Source</th>
        <th width="25%">Target</th>
        <th >Tags</th>        
    </thead>
    <tbody>
            
        <tr>
            <td>{TemplateHelper::getTaskSourceLanguage($task)}</td>
            <td>{TemplateHelper::getTaskTargetLanguage($task)}</td>
            <td>
                {assign var="taskTags" value=$task->getTags()}
		{foreach $taskTags as $tag}
		{/foreach}
            </td>
        </tr>
    </tbody>
</table>
            
<div class="well">
    <table width="100%">
        <thead>
        <th width="48%" align="left">Task Comment:<hr/></th>
        <th></th>
        <th width="48%" align="left">Project Description:<hr/></th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <i>
                    {if $task->getComment() != ''}
                        {$task->getComment()}
                    {else}
                       No comment has been added.
                    {/if}
                    </i>
                </td>
                <td></td>
                <td>
                    <i>
                    {if $project->getDescription() != ''}
                        {$project->getDescription()}
                    {else}
                        No description has been added.
                    {/if}
                    </i>
                </td>
            </tr>
        </tbody>
    </table>
</div> 
    
    
<table class="table table-striped" width="100%">
    <thead>
        <th>Deadline</th>
        <th>Claimed Date</th> 
        <th>Claimed By</th> 
    </thead>
    <tbody>
            
        <tr>
            <td valign="middle">{$task->getDeadline()}</td>
            <td></td>
            <td></td>            
            <td>
                {*todo add check once revoked*}
                <form method="post" action="{urlFor name="task-feedback" options="task_id.$task_id"}">
                    <input type="hidden" name="task_id" value="{$task_id}" />                    
                    <input type="hidden" name="revokeTask" value="1" />
                    <a href="#" onclick="this.parentNode.submit()" class="btn btn-small btn-inverse">
                        <i class="icon-remove icon-white"></i> Revoke Task From User
                    </a> 
                </form>
            </td>
        </tr>
    </tbody>
</table>
                
<div style="margin-bottom: 40px"></div>  

<div class="well">
    <b>User Feedback:</b><hr/>    
    <form id="taskUserFeedback" enctype="application/x-www-form-urlencoded" method="post" action="{urlFor name="task-feedback" options="task_id.$task_id"}">
        <textarea wrap="soft" style="width: 99%" maxlength="4096" rows="10" name="feedback">You can provide direct feedback to the translator who claimed this task here.</textarea>                    
        <p style="margin-bottom:30px;"></p>  
        <span style="float: right; position: relative; top:-20px">
            <button type="submit" value="Submit" name="submit" class="btn btn-primary">
                <i class="icon-upload icon-white"></i> Submit
            </button>        
            <button type="reset" value="Reset" name="reset" class="btn btn-primary">
                <i class="icon-repeat icon-white"></i> Reset
            </button>
        </span>
    </form>
        
</div>  
{include file="footer.tpl"}