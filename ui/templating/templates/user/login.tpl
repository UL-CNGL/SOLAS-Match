{include file="header.tpl"}

    <div class="page-header">
            <h1>{Localisation::getTranslation('login_log_in_to')} {Settings::get('site.name')}</h1>
    </div>

    {if isset($flash['error'])}
        <div class="alert alert-error">
            <a class="close" data-dismiss="alert" href="{urlFor name='login'}">×</a>
            <p>{$flash['error']}</p>
        </div>
    {/if}

    {if isset($flash['info'])}
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert" href="{urlFor name='login'}">×</a>
            <p><strong>{Localisation::getTranslation('common_note')}: </strong>{$flash['info']}</p>
        </div>
    {/if}

    {if isset($flash['success'])}
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="{urlFor name='login'}">×</a>
            <p><strong>{Localisation::getTranslation('common_success')}! </strong>{$flash['success']}</p>
        </div>
    {/if}

    {if isset($openid)&& ($openid==='n'||$openid==='h' )}
        <form method="post" action="{urlFor name='login'}" accept-charset="utf-8">
            <label for="email"><strong>{Localisation::getTranslation('common_email')}</strong></label>
            <input type="text" name="email" id="email"/>
            <label for="password"><strong>{Localisation::getTranslation('common_password')}</strong></label>
            <input type="password" name="password" id="password"/>
            <div>
                <button type="submit" name="login" class="btn btn-primary">
  				    <i class="icon-share icon-white"></i> {Localisation::getTranslation('common_log_in')}
				</button>
				
				<button type="submit" class="btn btn-inverse" name="password_reset">
  				    <i class="icon-exclamation-sign icon-white"></i> {Localisation::getTranslation('login_reset_password')}
				</button>
            </div>
        </form>
    {/if}

    {if isset($openid) && ($openid === 'y' || $openid === 'h')}
        <!-- Simple OpenID Selector -->
        <form action="{urlFor name='login'}" method="post" id="openid_form">
            <input type="hidden" name="action" value="verify" />
            <fieldset>
                <legend>{Localisation::getTranslation('common_signin_or_create_new_account')}</legend>
                <div id="openid_choice">
                    <p>{Localisation::getTranslation('common_please_click_your_account_provider')}</p>
                    {if isset($gplus) && ($gplus === 'y')}
	                    <div id="gSignInWrapper">
	                        <div id="customGplusBtn" class="customGPlusSignIn">
	                           <span id="customGplusBtnIcon"></span>
	                           <span id="customGplusBtnText">Google</span>
	                        </div>
	                    </div>
                    {/if}
                    <div id="openid_btns"></div>
                </div>
                <div id="openid_input_area">
                    <input id="openid_identifier" name="openid_identifier" type="text" />
                    <input id="openid_submit" type="submit" class="btn btn-primary" value="{Localisation::getTranslation('login_signin')}"/>
                </div>
                <noscript>
                    <p>
                        {Localisation::getTranslation('common_openid_is_service_that_allows_you_to_logon_to_many_different_websites_using_a_single_indentity')}
                        {sprintf(Localisation::getTranslation('login_0'), "http://openid.net/what/", "http://openid.net/get/")}
                    </p>
                </noscript>
            </fieldset>
        </form>
        <!-- /Simple OpenID Selector -->
    {/if}
{include file="footer.tpl"}
