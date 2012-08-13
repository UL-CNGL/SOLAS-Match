{include file="header.tpl"}
<div class="page-header">
    <h1>Tag List <small> All tags in the SOLAS Match System.</small></h1>
</div>

{if isset($user_tags)}
    <h1>Subscribed Tags <small>These tags are more likely to show up in your stream of tasks.</small></h1>
    <ul class="nav nav-list unstyled">
    {foreach $user_tags as $tag}
        <li>
            <p><a class="tag label" href="{urlFor name="tag-details" options="label.$tag"}">{$tag}</a></p>
        </li>
    {/foreach}
    </ul>
{/if}

{if isset($all_tags)}
    <h1>All Tags <small>List of all tags in the system</small></h1>
    <ul class="nav nav-list unstyled">
    {foreach $all_tags as $tag}
        <li>
            <p><a class="tag label" href="{urlFor name="tag-details" options="label.$tag"}">{$tag}</a></p>
        </li>
    {/foreach}
    </ul>
{/if}

{include file='footer.tpl'}