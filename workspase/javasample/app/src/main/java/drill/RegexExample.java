package drill;

import java.util.regex.*;

public class RegexExample {
    public static void main(String args[]) {
        String content = "I am noob " + "from runoob.com.";

        String pattern = ".*runoob.*";

        boolean isMatch = Pattern.matches(pattern, content);
        System.out.println("字符串中是否包含了 'runoob' 子字符串? " + isMatch);
    }

    public static int max(int num1, int num2) {// これは二つの数字比べるメソッド
        return num1 > num2 ? num1 : num2;
    }

    public static void nPrintln(String message, int n) {// 複数回印刷メソッド
        for (int i = 0; i < n; i++) {
            System.out.println(message);
        }
    }

}
