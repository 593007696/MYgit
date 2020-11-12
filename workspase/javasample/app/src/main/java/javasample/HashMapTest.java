package javasample;

import java.util.HashMap;

public class HashMapTest {
    public static void main(String[] args) {
        HashMap<String, String> map = new HashMap<>();
        map.put("red", "赤");
        map.put("blue", "青");
        map.put("pink", "桃");
        map.put("green", "緑");

        System.out.println(map.get("red"));
        System.out.println(map.get("blue"));
        System.out.println(map.get("pink"));
        System.out.println(map.get("green"));

    }

}
