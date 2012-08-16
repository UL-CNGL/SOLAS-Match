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
    <div class='page-header'><h1>
    {if $org->getName() != ''}
        {$org->getName()}
    {else}
        Organisation Profile
    {/if}
    <small> An organisation on SOLAS Match </small>
    {assign var="org_id" value=$org->getId()}
    {if in_array($user->getUserId(), $org_members)}
        <a href="{urlFor name="org-private-profile" options="org_id.$org_id"}" class='pull-right btn btn-primary'>Edit Profile</a>
    {else}
        <a href="{urlFor name="org-request-membership" options="org_id.$org_id"}" class='pull-right btn btn-primary'>Request Membership</a>
    {/if}
    </h1></div>
{/if}

{if $org->getName() != ''}
    <h3>Organisation Name</h3>
    <p>{$org->getName()}</p>
{/if}

{if $org->getHomePage() != ''}
    <h3>Home Page</h3>
    <p><a href='{$org->getHomePage()}'>{$org->getHomePage()}</a></p>
{/if}

{if $org->getBiography() != ''}
    <h3>Biography</h3>
    <p>{$org->getBiography()}</p>
{/if}

<h3>
    Organisation Badges
    {if in_array($user->getUserId(), $org_members)}
        <a href="{urlFor name="org-create-badge" options="org_id.$org_id"}" class='pull-right btn'>
            Create Badge
        </a>
    {/if}
</h3>
{if $org_badges != NULL && count($org_badges) > 0}
    {foreach $org_badges as $badge}
        <p>
            {if in_array($user->getUserId(), $org_members)}
                {assign var="badge_id" value=$badge['badge_id']}
                <a href="{urlFor name="org-assign-badge" options="org_id.$org_id|badge_id.$badge_id"}" class="btn">
                    Assign
                </a>
            {/if}
            {$badge['title']}: {$badge['description']}
        </p>
    {/foreach}
    <br />
{else}
    <br />
    <p class="alert alert-info">
        There are no badges associated with this organisation.
        Add organisation badges <a href="{urlFor name="org-create-badge" options="org_id.$org_id"}">here</a>.
    </p>
{/if}

{if in_array($user->getUserId(), $org_members)}
    <a href="{urlFor name="org-request-queue" options="org_id.$org_id"}" class="btn btn-primary">View Membership Requests</a>
{/if}

{include file='footer.tpl'}
