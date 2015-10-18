package appathon.app.whereismycash;

import java.util.List;

/**
 * Created by yep on 07/03/2015.
 */
public class GroupData {
    private int ID;
    private String name;
    private List<String> people;
    private int status; //0 = invited, 1 = accepted
    private String invitedBy;
    private Double balance;


    public GroupData(int ID, String name, int status, String invitedBy, Double balance) {
        this.ID = ID;
        this.name = name;
        this.people = people;
        this.status = status;
        this.invitedBy = invitedBy;
        this.balance = balance;
    }

    public int getID() {
        return ID;
    }

    public String getName() {
        return name;
    }

    public List<String> getPeople() {
        return people;
    }

    public int getStatus() {
        return status;
    }

    public String getInvitedBy() {
        return invitedBy;
    }

    public Double getBalance() {
        return balance;
    }
}
