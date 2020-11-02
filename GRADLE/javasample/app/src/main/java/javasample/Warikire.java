package javasample;

import java.util.Scanner;

public class Warikire {
    public static void main(String[] args) {

        System.out.print("请输入一个数：");
        Scanner sc = new Scanner(System.in);
        long l = sc.nextLong();
        long n = l;
        sc.close();
        int count = 0;
        while (n > 8) {
            n /= 9;
            count++;
        }
        System.out.println(l + "能被" + count + "个9整除。");

    }

}
