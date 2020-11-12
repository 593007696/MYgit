package javasample;

public class StringTest {
    public static void main(String[] args) {
        String str = "abcdefg";
        System.out.println("文字数" + str.length() + "です。");
        System.out.println("3文字目は" + str.charAt(2) + "です。");
        System.out.println("大文字" + str.toUpperCase());
        System.out.println(String.join("?", "a", "b", "c"));
    }
}
