<h2>Add a new account</h2>
<form action="{$action}" method="post">
    <section class="formField">
        <label for="txtName">Username:</label><br />
        <input type="text" id="txtName" name="txtName" value="{$username}" />
        <span class="error">{$errUsername}</span>
    </section>

    <section class="formField">
        <label for="txtPass">Password:</label><br />
        <input type="password" id="txtPass" name="txtPass" />
        <span class="error">{$errPass}</span>
    </section>

    <section class="formField">
        <label for="txtRePass">Re&#45;enter Password:</label><br />
        <input type="password" id="txtRePass" name="txtRePass" />
        <span class="error">{$errRePass}</span>
    </section>

    <section class="formButtons">
        <input type="submit" name="submit" value="add" />
        <input type="submit" name="submit" value="cancel" />
    </section>
</form>