package appathon.app.whereismycash;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

/**
 * Created by yep on 07/03/2015.
 */
public class LoginData {
    private static JSONObject data;
    private static int ID;
    private static String username;
    private static int loggedIn;
    private static String currency;
    private static List<GroupData> groups = new ArrayList<GroupData>();


    public static void setData(JSONObject o)
    {
        data = o;
        try {
            loggedIn = data.getInt("result");
            ID = data.getInt("ID_U");
            username = data.getString("name");
            JSONObject groupsList = data.getJSONObject("groups");
            currency = data.getString("currency");
            Iterator<?> keys = groupsList.keys();

            while( keys.hasNext() ){
                String key = (String)keys.next();
                if( groupsList.get(key) instanceof JSONObject ){
                    JSONObject group = groupsList.getJSONObject(key);
                    groups.add(new GroupData(group.getInt("ID_G"), group.getString("name"),
                            group.getInt("status"), group.getString("invited_by"), group.getDouble("balance")));
                }
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    public static int getID() {
        return ID;
    }

    public static String getUsername() {
        return username;
    }

    public static String getCurrency() {
        return currency;
    }

    public static List<GroupData> getGroups() {
        return groups;
    }

    public static boolean isLoggedIn() {
        if(loggedIn == 1)
            return true;
        else
            return false;
    }
}
