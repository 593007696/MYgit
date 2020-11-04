package javasample;

public class StringBuilderTest {
    public static void main(String[] args) {
        StringBuilder sb = new StringBuilder();
        sb.append("abc").append("def").append("ghi");
        System.out.println(sb.toString());
        sb.append("jkl");
        System.out.println(sb.toString());
    }
}
