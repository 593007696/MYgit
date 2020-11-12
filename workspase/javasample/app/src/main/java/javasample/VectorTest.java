package javasample;

import java.util.Vector;
import java.util.List;

public class VectorTest {
    public static void main(String[] args) {
        List<String> list = new Vector<>();
        list.add("1");
        list.add("2");
        list.add("3");
        list.remove("2");
        System.out.println(list);

    }

}
