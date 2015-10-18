package appathon.app.whereismycash;

import android.app.Activity;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;


public class GroupList extends Activity {
    private ListView groups;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_group_list);

        groups = (ListView) findViewById(R.id.groups_list_view);
        groups.setAdapter(new ListViewAdapter(this.getBaseContext()));
        groups.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Toast.makeText(view.getContext(), "position clicked: " + position,
                        Toast.LENGTH_SHORT).show();
            }
        });
    }

    public void OnClick_NewGroup(View v) {
//        Intent intent = new Intent(v.getContext(), Register.class);
//        startActivity(intent);
        finish();
    }

}
