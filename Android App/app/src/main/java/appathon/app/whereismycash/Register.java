package appathon.app.whereismycash;

import android.app.Activity;
import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.CheckBox;
import android.widget.EditText;


public class Register extends Activity {
    private EditText name, email, password;
    private CheckBox cbox;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        name = (EditText) findViewById(R.id.register_input_name);
        email = (EditText) findViewById(R.id.register_input_email);
        password = (EditText) findViewById(R.id.register_input_password);
        cbox = (CheckBox) findViewById(R.id.register_input_checkbox);
    }

    //called register button is pressed
    public void OnClick_RegisterUser(View v) {
        String string_name, string_email, string_password;
        Boolean checked;
        string_name = name.getText().toString();
        string_email = email.getText().toString();
        string_password = password.getText().toString();
        if (cbox.isChecked()) checked = true;
        else checked = false;



        //DO YOUR STUFF HERE...

        Intent intent = new Intent(v.getContext(), GroupList.class);
        startActivity(intent);
        finish();

    }

}
