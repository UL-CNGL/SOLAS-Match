{include file='header.tpl'}

<span class="hidden">

    <!-- Parameters... -->
    <div id="siteLocation">{$siteLocation}</div>
    <div id="siteAPI">{$siteAPI}</div>
    <div id="user_id">{$user_id}</div>
    <div id="secondaryLanguageCount">{$secondaryLanguageCount}</div>
    {assign var="i" value=0}
    {foreach $secondaryLanguages as $secondaryLanguage}
        <div id="userSecondaryLanguagesLanguageCode_{$i}">{$secondaryLanguage->getLanguageCode()}</div>
        <div id="userSecondaryLanguagesCountryCode_{$i}">{$secondaryLanguage->getCountryCode()}</div>
        {assign var="i" value=$i+1}
    {/foreach}
    <div id="langPrefSelectCodeSaved">{$langPrefSelectCode}</div>

    <!-- Templates... -->
    <div id="template_language_options">
        <option value=""></option>
        {foreach $languages as $language}
            <option value="{$language->getCode()}">{$language->getName()}</option>
        {/foreach}
    </div>

    <div id="template_country_options">
        <option value=""></option>
        {foreach $countries as $country}
            <option value="{$country->getCode()}">{$country->getName()}</option>
        {/foreach}
    </div>

</span>

{if isset($user)}
    <div class="page-header">
        <h1>
            <img src="http://www.gravatar.com/avatar/{md5( strtolower( trim($user->getEmail())))}?s=80&r=g" alt="" />
            {if $user->getDisplayName() != ''}
                {$user->getDisplayName()|escape:'html':'UTF-8'}
            {else}
                {Localisation::getTranslation('user_private_profile_private_profile')}
            {/if}
            <small>{Localisation::getTranslation('user_private_profile_0')}</small><br>
            <small>{Localisation::getTranslation('common_denotes_a_required_field')}</small>
        </h1>
    </div>
{/if}

<div class="well alert-info">
    <p><strong>{Localisation::getTranslation('user_private_profile_please_note')}</strong></p>
    <p>{Localisation::getTranslation('user_private_profile_3')} {Localisation::getTranslation('user_private_profile_4')}</p>
</div>

<div class="well">

    {if isset($flash['error'])}
        <p class="alert alert-error">
            {$flash['error']}
        </p>
    {/if}

    <div id="placeholder_for_errors_1"></div>

    <form method="post" action="{urlFor name="user-private-profile" options="user_id.$user_id"}" enctype="multipart/form-data" accept-charset="utf-8">
        <table>
            <tr valign="top" align="center">
                <td width="50%">
                    <div id="loading_warning">
                        <p><i>{Localisation::getTranslation('common_loading')}</i></p>
                    </div>
                    <label for='displayName'><strong>{Localisation::getTranslation('common_display_name')}: <span style="color: red">*</span></strong></label>
                    <input type='text' style="width: 80%" value="{$user->getDisplayName()|escape:'html':'UTF-8'}" name="displayName" id="displayName" />

                    <div id="language_area">
                        <div id = "nativeLanguageDiv">
                            <label><strong>{Localisation::getTranslation('common_native_language')}:</strong></label>
                            <select name="nativeLanguageSelect" id="nativeLanguageSelect" style="width: 82%">
                                <option value=""></option>
                                {foreach $languages as $language}
                                    <option value="{$language->getCode()}" {if $language->getCode() == $nativeLanguageSelectCode}selected="selected"{/if}>{$language->getName()}</option>
                                {/foreach}
                            </select>
                            <select name="nativeCountrySelect" id="nativeCountrySelect" style="width: 82%">
                                <option value=""></option>
                                {foreach $countries as $country}
                                    <option value="{$country->getCode()}" {if $country->getCode() == $nativeCountrySelectCode}selected="selected"{/if}>{$country->getName()}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div id="secondaryLanguageDiv">
                            <label><strong>{Localisation::getTranslation('common_secondary_languages')}:</strong></label>
                            <button onclick="addSecondaryLanguage(); return false;" class="btn btn-success" id="addLanguageButton" {if $secondaryLanguageCount >= 10}disabled{/if}>
                                <i class="icon-upload icon-white"></i> {Localisation::getTranslation('user_private_profile_add_secondary_language')}
                            </button>
                            <button onclick="removeSecondaryLanguage(); return false;" class="btn btn-inverse" id="removeLanguageButton" {if $secondaryLanguageCount <= 1}disabled{/if}>
                                <i class="icon-fire icon-white"></i> {Localisation::getTranslation('common_remove')}
                            </button>
                        </div>
                    </div>

                    <label for='biography'><strong>{Localisation::getTranslation('common_biography')}:</strong></label>
                    <textarea cols='40' rows='7' style="width: 80%" name="biography" id="biography">{$user->getBiography()|escape:'html':'UTF-8'}</textarea>

                    <div id="siteLangSelectDiv">
                        <label for='languagePreference' style="margin-top:6px;"'><strong>{Localisation::getTranslation('common_language_preference')}:</strong></label>
                        <select name="langPrefSelect" id="langPrefSelect" style="width: 80%">
                            {foreach $locs as $loc}
                                <option value="{$loc->getCode()}" {if $loc->getCode() == $langPrefSelectCode}selected="selected"{/if}>{$loc->getName()}</option>
                            {/foreach}
                        </select>

                    </div>
                    <div id="loading_warning1">
                        <p><i>{Localisation::getTranslation('common_loading')}</i></p>
                    </div>
                </td>
                <td width="50%">
                    <label for='firstName'><strong>{Localisation::getTranslation('common_first_name')}:</strong></label>
                    <input type='text' value="{$userPersonalInfo->getFirstName()|escape:'html':'UTF-8'}" style="width: 80%" name="firstName" id="firstName"/>

                    <label for='lastName'><strong>{Localisation::getTranslation('common_last_name')}:</strong></label>
                    <input type='text' value="{$userPersonalInfo->getLastName()|escape:'html':'UTF-8'}" style="width: 80%" name="lastName" id="lastName" />

                    <label for='mobileNumber'><strong>{Localisation::getTranslation('common_mobile_number')}:</strong></label>
                    <input type='text' value="{$userPersonalInfo->getMobileNumber()|escape:'html':'UTF-8'}" style="width: 80%" name="mobileNumber" id="mobileNumber" />

                    <label for='businessNumber'><strong>{Localisation::getTranslation('common_business_number')}:</strong></label>
                    <input type='text' value="{$userPersonalInfo->getBusinessNumber()|escape:'html':'UTF-8'}" style="width: 80%" name="businessNumber" id="businessNumber" />

                    <label for='jobTitle'><strong>{Localisation::getTranslation('common_job_title')}:</strong></label>
                    <input type='text' value="{$userPersonalInfo->getJobTitle()|escape:'html':'UTF-8'}" style="width: 80%" name="jobTitle" id="jobTitle" />

                    <label for='address'><strong>{Localisation::getTranslation('common_address')}:</strong></label>
                    <textarea cols='40' rows='5' style="width: 80%" name="address" id="address">{$userPersonalInfo->getAddress()|escape:'html':'UTF-8'}</textarea>

                    <label for='city'><strong>{Localisation::getTranslation('common_city')}:</strong></label>
                    <input type='text' value="{$userPersonalInfo->getCity()|escape:'html':'UTF-8'}" style="width: 80%" name="city" id="city" />

                    <label for='country'><strong>{Localisation::getTranslation('common_country')}:</strong></label>
                    <input type='text' value="{$userPersonalInfo->getCountry()|escape:'html':'UTF-8'}" style="width: 80%" name="country" id="country" />

                    <label for="receiveCredit"><strong>{Localisation::getTranslation('user_private_profile_receive_credit')}:</strong></label>
                    <input type="checkbox" {if $userPersonalInfo->getReceiveCredit()}checked="checked"{/if} name="receiveCredit" id="receiveCredit" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td colspan="3" align="center" style="font-weight: bold">
                                {Localisation::getTranslation('user_private_profile_task_type_preferences')}:
                            </td>
                        </tr>
                        <tr align="center">
                            <td>
                                {Localisation::getTranslation('user_private_profile_translating')}
                            </td>
                            <td>
                                {Localisation::getTranslation('user_private_profile_proofreading')}
                            </td>
                            <td>
                                {Localisation::getTranslation('user_private_profile_interpreting')}
                            </td>
                        </tr>
                        <tr align="center">
                            <td>
                                <input type="checkbox" {if $translator}checked="checked"{/if} name="translator" id="translator" />
                            </td>
                            <td>
                                <input type="checkbox" {if $proofreader}checked="checked"{/if} name="proofreader" id="proofreader" />
                            </td>
                            <td>
                                <input type="checkbox" {if $interpreter}checked="checked"{/if} name="interpreter" id="interpreter" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-bottom: 20px">
                    <hr/>
                    <div id="placeholder_for_errors_2"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit" onclick="return validateForm();" class='btn btn-primary' id="updateBtn">
                        <i class="icon-refresh icon-white"></i> {Localisation::getTranslation('user_private_profile_update_profile_details')}
                    </button>
                    <button onclick="deleteUser(); return false;" class="btn btn-inverse" id="deleteBtn">
                        <i class="icon-fire icon-white"></i> {Localisation::getTranslation('user_private_profile_delete_user_account')}
                    </button>
                </td>
            </tr>
        </table>

        <input type="hidden" name="sesskey" value="{$sesskey}" />
    </form>
</div>

{include file='footer.tpl'}
