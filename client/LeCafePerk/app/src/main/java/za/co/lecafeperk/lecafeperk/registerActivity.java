package za.co.lecafeperk.lecafeperk;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.backendless.Backendless;
import com.backendless.BackendlessUser;
import com.backendless.async.callback.AsyncCallback;
import com.backendless.exceptions.BackendlessFault;

public class registerActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
    }

    public void launchProfile(View view) {
        Intent intent = new Intent(registerActivity.this, Profile.class);
        startActivity(intent);
    }

    public void btnRegister(View view) {

        //Toast.makeText(this, "click", Toast.LENGTH_LONG).show();

        EditText nameInput = findViewById(R.id.input_name);
        EditText surnameInput = findViewById(R.id.input_surname);
        EditText emailInput = findViewById(R.id.input_email);
        EditText cellInput = findViewById(R.id.input_cell);
        EditText passwordInput = findViewById(R.id.input_password);

        BackendlessUser user = new BackendlessUser();
        user.setEmail(emailInput.getText().toString());
        user.setPassword(passwordInput.getText().toString());
        user.setProperty("name",nameInput.getText().toString());
        user.setProperty("surname",surnameInput.getText().toString());
        user.setProperty("cell",cellInput.getText().toString());

        Backendless.UserService.register(user, new AsyncCallback<BackendlessUser>() {
            @Override
            public void handleResponse(BackendlessUser response) {
                //successful user registration code here
                Toast.makeText(getApplicationContext(), "success", Toast.LENGTH_LONG).show();
            }

            @Override
            public void handleFault(BackendlessFault fault) {
                //unsuccessful user registration code here
                Toast.makeText(getApplicationContext(), "fail", Toast.LENGTH_LONG).show();
            }
        });




    }
}
