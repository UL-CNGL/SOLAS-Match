{include file='header.tpl'}

{if isset($user)}
    <div class="page-header"><h1>
    <img src="http://www.gravatar.com/avatar/{md5( strtolower( trim($user->getEmail())))}?s=80&r=g" alt="" />
    {if $user->getDisplayName() != ''}
        {$user->getDisplayName()}
    {else}
        Public Profile
    {/if}
    <small>Update your personal details here</small>
    </h1></div>
{/if}


{if isset($warning) && $warning == true }
    <p>Invalid input, please fill in all options below.</p>
{/if}
 
<form method='post' action='{urlFor name='user-private-profile'}' class='well'>
    <label for='name'>Public display name:</label>
    <input type='text' name='name' id='name'
    {if $user->getDisplayName() != ''}
        value='{$user->getDisplayName()}'
    {else}
        placeholder='Name'
    {/if} />
    <label for='nLanguage'>Native Language:</label>
    {if isset($languages)}
        <select name="nLanguage" id="nLanguage">
            {foreach $languages as $language}
                {if $user->getNativeLanguageID() == $language->getID()}
                    <option value="{$language->getID()}" selected="selected">{$language->getEnName()}</option>
                {else}
                    <option value="{$language->getID()}">{$language->getEnName()}</option>
                {/if}
            {/foreach}
        </select>
    {if isset($countries)}
        <select name="nLanguageCountry" id="nLanguageCountry">
            {foreach $countries as $country}
                {if $user->getNativeRegionID() == $country->getID()}
                <option value="{$country->getID()}" selected="selected">{$country->getEnName()}</option>
                {else}
                    <option value="{$country->getID()}">{$country->getEnName()}</option>
                {/if}
            {/foreach}
        </select>
    {/if}
    {else}
        <input type='text' name='nLanguage' id='nLanguage' value={$user->getNativeLanguage()} />
    {/if}
    <label for='bio'>Biography:</label>
    <textarea name='bio' cols='40' rows='5' {if $user->getBiography() == ''} placeholder="Enter Bio Here" {/if}
    >{if $user->getBiography() != ''}{$user->getBiography()}{/if}</textarea>
    <p>Register with <a href="http://en.gravatar.com/" target="_blank">Gravatar</a> to choose your avatar</p>

    <p> 
        <button type='submit' class='btn btn-primary' name='submit'>
            <i class="icon-refresh icon-white"></i> Update
        </button>
    </p>
</form>
                  
{include file='footer.tpl'}