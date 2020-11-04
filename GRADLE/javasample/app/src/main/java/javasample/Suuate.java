package javasample;

import java.util.*;

public class Suuate {
    public static void main(String[] args) {

        String title = "数当てゲームです。\n0以外入力するとスタートです。";
        String giveup = "諦めるは0を入力してください。";
        System.out.println(title);

        int a = 100;
        int b = 999;

        Random r = new Random();
        int n = r.nextInt(b - a + 1) + a;

        Scanner sc = new Scanner(System.in);
        int num = sc.nextInt();

        OUT: while (num != 0) {

            System.out.println("3桁の数字100～999までの3桁の数字を当ててください。");

            while (num != n) {

                num = sc.nextInt();

                if (num == 0) {
                    System.out.println(n + "は正解です！");
                    System.out.println("お疲れ様でした！次回頑張ってください！");

                    break OUT;
                } else {

                    if ((num + "").length() != 3) {
                        System.out.println("三桁の数値入力してください！");
                        continue;
                    }

                }

                if (num > n) {
                    System.out.println("大きいです！もう一度入力してください！");
                    System.out.println(giveup);

                } else {
                    System.out.println("小さいです！もう一度入力してください！");
                    System.out.println(giveup);

                }

            }
            System.out.println("正解です！\nおめでとうございます！\n0を入力すると終了です。\nそれ以外もう一度やります！");
            num = sc.nextInt();
        }
        System.out.println("お疲れ様でした！");
        sc.close();
    }
}
