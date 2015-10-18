package appathon.app.whereismycash;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.content.Intent;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class Login extends Activity {

    private EditText email, password;
    private View v;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        email = (EditText) findViewById(R.id.login_input_email);
        password = (EditText) findViewById(R.id.login_input_password);
    }

    //called when login button is pressed
    public void OnClick_Login(View v) {
        Log.v("wtf", "CLICKED");
        this.v = v;
        LoginTask t = new LoginTask();
        t.execute("");
       // Intent intent = new Intent(v.getContext(), GroupList.class);
       // startActivity(intent);
       // finish();;

    }

    //called when activity_register button is pressed
    public void OnClick_Register(View v) {
        Intent intent = new Intent(v.getContext(), Register.class);
        startActivity(intent);
        finish();
    }
    private class LoginTask extends AsyncTask<String, Void, String> {
        JSONObject result;

        @Override
        protected String doInBackground(String... params) {
            JSONParser jParser = new JSONParser();
            String login_url = "http://wheresmycash.tk/login.php";
            //get strings
            String string_email, string_password;
            string_email =  email.getText().toString();
            string_password = password.getText().toString();

            List<NameValuePair> parameters = new ArrayList<NameValuePair>();
            parameters.add(new BasicNameValuePair("email", string_email) );
            parameters.add(new BasicNameValuePair("password", string_password));

            result = jParser.makeHttpRequest(login_url, "POST", parameters);
            LoginData.setData(result);
            return "Executed";
        }

        @Override
        protected void onPostExecute(String result) {
            if(!LoginData.isLoggedIn()) //need to show a message to the user
            {
                return;
            }
            Intent intent = new Intent(v.getContext(), GroupList.class);
            startActivity(intent);
            finish();
        }

        @Override
        protected void onPreExecute() {}

        @Override
        protected void onProgressUpdate(Void... values) {}
    }
}