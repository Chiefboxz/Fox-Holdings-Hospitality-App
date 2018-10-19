package za.co.lecafeperk.lecafeperk;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import com.android.volley.Request;
import com.android.volley.Request.Method;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.Response.Listener;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class Profile extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);


    }

    public void launchRegister (View view){
        Intent intent = new Intent(Profile.this, registerActivity.class);
        startActivity(intent);
    }

    public void btnLoginClicked(View v) throws JSONException {

        /*Toast toast = Toast.makeText(Profile.this, "No Internet Connection", Toast.LENGTH_LONG);
        toast.show();
        */

        EditText txtEmailInput = (EditText) findViewById(R.id.txtEmail);
        EditText txtPasswordInput = (EditText) findViewById(R.id.txtPassword);
        String usernameInput = txtEmailInput.getText().toString();
        String passwordInput = txtPasswordInput.getText().toString();
        if (usernameInput.contains("@")) {

            RequestQueue MyRequestQueue = Volley.newRequestQueue(this);
            // JSONArray data = new JSONArray();
            JSONObject data = new JSONObject();
            data.put("email", usernameInput);
            data.put("password", passwordInput);


            String url = "http://192.168.43.175:3000/api/v1/login";
            // StringRequest MyStringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {

            JsonObjectRequest MyStringRequest = new JsonObjectRequest(Method.POST, url, data , new Response.Listener<JSONObject>() {

                @Override
                public void onResponse(JSONObject response) {

                    // code to execute when server responds
                    Toast toast = Toast.makeText(Profile.this, "Server has responded.", Toast.LENGTH_LONG);
                    toast.show();

                }

            }, new Response.ErrorListener() { //Create an error listener to handle errors appropriately.
                @Override
                public void onErrorResponse(VolleyError error) {
                    //This code is executed if there is an error.
                    Toast toast = Toast.makeText(Profile.this, "Error connecting to server.", Toast.LENGTH_LONG);
                    toast.show();
                    System.out.println("Svr Error" + error);

                }
            });

            MyRequestQueue.add(MyStringRequest);

        }
        else{
            Toast toast = Toast.makeText(Profile.this, "Please enter a valid email.", Toast.LENGTH_LONG);
            toast.show();
        }

    }

}
