package javasample;

public class IFSample {
    public static void main(String[] args) {

        System.out.println("数字入力");
        java.util.Scanner sc = new java.util.Scanner(System.in);
        int n = sc.nextInt();
        sc.close();
        System.out.println("nの値は" + n + "です。");
        if (n % 2 == 0) {
            System.out.println("偶数");
        } else {
            System.out.println("奇数");
        }

    }

}
