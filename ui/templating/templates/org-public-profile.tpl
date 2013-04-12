{include file='header.tpl'}

{if isset($org)}
    {if isset($flash['error'])}
        <div class="alert alert-error">
            {$flash['error']}
        </div>
    {/if}
    {if isset($flash['success'])}
        <div class="alert alert-success">
            {$flash['success']}
        </div>
    {/if}
    {if isset($flash['info'])}
        <div class="alert alert-info">
            {$flash['info']}
        </div>
    {/if}
    <div class='page-header'>
        <h1>
            {if $org->getName() != ''}
                {$org->getName()}
            {else}
                Organisation Profile
            {/if}
            <small>An organisation on SOLAS Match.</small>
            {assign var="org_id" value=$org->getId()}
            {if isset($user)}
                {if in_array($user->getId(), $org_members)}
                    <a href="{urlFor name="org-private-profile" options="org_id.$org_id"}" class='pull-right btn btn-primary'>
                        <i class="icon-wrench icon-white"></i> Edit Organisation Details
                    </a>
                {else}
                    <a href="{urlFor name="org-request-membership" options="org_id.$org_id"}" class='pull-right btn btn-primary'>
                        <i class="icon-ok-circle icon-white"></i> Request Membership
                    </a>
                {/if}
            {/if}
        </h1>
    </div>
{/if}

    <div class="well">
        <table border="0" width="100%">
            <thead>
            <th align="left" width="48%">Biography:<hr/></th>
            </thead>
            <tbody>
                <tr valign="top">
                    <td>
                        <i>
                        {if $org->getBiography() != ''}
                            {$org->getBiography()}
                        {else}
                            This organisation has no biography listed.
                        {/if}
                        </i>
                    </td>
                </tr>    
                <tr><td><hr /></td></tr>
                <tr>
                    <td>
                        {if $org->getHomePage() != '' && $org->getHomePage() != 'http://'}
                            <strong>Home Page:</strong> <a target="_blank" href='{$org->getHomePage()}'>{$org->getHomePage()}</a>
                        {/if}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
                
    <p style="margin-bottom: 60px" />         
    <h1 class="page-header">
        Badges
        <small>Overview of badges created by this organisation.</small>

        {if isset($user)}
            {if in_array($user->getId(), $org_members)}
                <a href="{urlFor name="org-create-badge" options="org_id.$org_id"}" class='pull-right btn btn-success'>
                    <i class="icon-star icon-white"></i> Create Badge
                </a>
            {/if}
        {/if}
    </h1>  
    <p style="margin-bottom: 40px" />   

{if $org_badges != NULL && count($org_badges) > 0}                
    <table class="table table-striped">
        <thead>            
            <th style="text-align: left">Name</th>
            <th>Description</th>
            {if in_array($user->getId(), $org_members)}
                <th>Edit</th>
                <th>Assign</th>
                <th>Delete</th>
            {/if}
        </thead>
        <tbody>
        {foreach $org_badges as $badge}
            {assign var="badge_id" value=$badge->getId()}
            {assign var="org_id" value=$org->getId()}
            <tr>
                <td style="text-align: left" width="20%">
                    <strong>{$badge->getTitle()}</strong>
                </td>
                <td width="35%">
                    {$badge->getDescription()}
                </td>
                {if isset($user)}
                    {if in_array($user->getId(), $org_members)}
                        <td>
                            <a href="{urlFor name="org-edit-badge" options="org_id.$org_id|badge_id.$badge_id"}" class='btn'>
                                <i class="icon-wrench icon-black"></i> Edit Badge
                            </a>
                        </td>
                        <td>
                            <a href="{urlFor name="org-manage-badge" options="org_id.$org_id|badge_id.$badge_id"}" class='btn'>
                                <i class="icon-plus-sign icon-black"></i> Assign Badge
                            </a>
                        </td>
                        <td>                        
                            <form method="post" action="{urlFor name="org-public-profile" options="org_id.$org_id"}">
                                <input type="hidden" name="badge_id" value="{$badge_id}" />
                                <input type="submit" class='btn btn-inverse' name="deleteBadge" value="    Delete Badge"
                                  onclick="return confirm('Are you sure you want to delete this badge?')" />                                 
                           </form> 
                            <i class="icon-fire icon-white" style="position:relative; right:44px; top:-40px;"></i> 
                        </td>  
                    {/if}
                {/if}
            </tr>
        {/foreach}
        </tbody>
    </table>
<br />
{else}
    <p class="alert alert-info">
        There are no badges associated with this organisation.
    </p>
    <p style="margin-bottom:20px;"></p>
{/if}
      
{if isset($user)}
   {if in_array($user->getId(), $org_members)}               
        <p style="margin-bottom: 40px" />         
        <h1 class="page-header">
            Membership Requests
            <small>Overview of users who have requested membership.</small>
            
        {if isset($user)}
            {if in_array($user->getId(), $org_members)}
                <a href="{urlFor name="org-request-queue" options="org_id.$org_id"}" class='pull-right btn btn-success'>
                    <i class="icon-star icon-white"></i> Add User
                </a>
            {/if}
        {/if}
        </h1>                  
        <p style="margin-bottom: 40px" />               
                
        {if isset($user_list) && count($user_list) > 0}
            <table class="table table-striped">
                <thead>            
                    <th style="text-align: left"><strong>Name</strong></th>
                    <th><strong>Biography</strong></th>
                    <th>Accept</th>
                    <th>Deny</th>
                </thead>
                <tbody>
                {foreach $user_list as $user}
                    <tr>
                        {assign var="user_id" value=$user->getId()}                        
                        {if $user->getDisplayName() != ''}
                            <td style="text-align: left">
                                <a href="{urlFor name="user-public-profile" options="user_id.$user_id"}">{$user->getDisplayName()}</a>
                            </td>
                        {/if}
                        <td width="50%">
                            <i>
                            {if $user->getBiography() != ''}
                                {$user->getBiography()}
                            {else}
                                No biography has been added.
                            {/if}
                            </i>
                        </td>
                        <form method="post" action="{urlFor name="org-public-profile" options="org_id.$org_id"}">
                            <input type="hidden" name="user_id" value="{$user->getId()}" />
                            <td>
                                <input type="submit" name="accept" value="    Accept Request" class="btn btn-primary" />
                                <i class="icon-ok-circle icon-white" style="position:relative; right:126px; top:2px;"></i>
                            </td>
                            <td>
                                <input type="submit" name="refuse" value="    Refuse Request" class="btn btn-inverse" />
                                <i class="icon-remove-circle icon-white" style="position:relative; right:126px; top:2px;"></i>
                            </td>
                        </form>
                    </tr>
                {/foreach}
                </tbody>
            </table>   
        {else}
            <p class="alert alert-info">
                There are no membership requests associated with this organisation.
            </p>
        {/if}
    {/if}
{/if}

{include file='footer.tpl'}