package appathon.app.whereismycash;


import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

public class ListViewAdapter extends BaseAdapter {

    private Context context;

    public ListViewAdapter(Context context) {
        this.context = context;
    }

    @Override
    public int getCount() {
        return 5;
    }

    @Override
    public Object getItem(int position) {
        return position;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder holder;
        if (convertView == null) {
            convertView = View.inflate(this.context, R.layout.group_list_item, null);
            holder = new ViewHolder();
            holder.groupname = (TextView) convertView.findViewById(R.id.list_item_groupname);
            holder.balance = (TextView) convertView.findViewById(R.id.list_item_balance);
            convertView.setTag(holder);

        } else {
            holder = (ViewHolder) convertView.getTag();
        }

        holder.groupname.setText("test name" + position);
        holder.balance.setText("balance: £:" + position);

        return convertView;
    }
}

