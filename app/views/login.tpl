<h3><i class="fa fa-cog faa-spin animated "> </i> LogIn </h3>
<div style="text-align:center; margin-bottom: 10px">
    <a href=<?= '"/login/with/?provider=twitter&token='.$token.'"' ?> class="icon-button twitter "><i class="icon-twitter fa fa-twitter"></i><span></span></a>
    <a href=<?= '"/login/with/?provider=facebook&token='.$token.'"' ?> class="icon-button facebook "><i class="icon-facebook fa fa-facebook"></i><span></span></a>
    <a href=<?= '"/login/with/?provider=google&token='.$token.'"' ?> class="icon-button google-plus "><i class="icon-google-plus fa fa-google-plus"></i><span></span></a>
</div>
<form name="login" id="form-login" method="post" action="/login/" data-abide>
    <div class="email-field">
        <input name="email" type="email" placeholder="Email" required maxlength="128">
        <small class="error" id="emailError">Valid email address is required.</small>
    </div>
    <div class="password-field">
        <input name="password" type="password" placeholder="Password" required maxlength="32">
        <small class="error" id="passError">Your password is required.</small>
    </div>
    <input name="token" type="hidden" value=<?= '"'.$token.'"' ?> >
    <button id="login-btn"><i class="fa fa-cog "></i> LogIn</button>
    <b>You don't have an account ?</b>
    <a href="/?register">Sign up from here</a>
</form>