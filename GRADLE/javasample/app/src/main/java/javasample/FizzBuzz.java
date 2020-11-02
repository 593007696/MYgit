package javasample;//パッケージ

public class FizzBuzz {// クラス
    public static void main(String[] args) {// メイン
        int num = 1;// 変数定義
        while (num <= 100) {

            if (num % 15 == 0) {

                System.out.println("FizzBuzz");

            } else if (num % 3 == 0) {

                System.out.println("Fizz");

            } else if (num % 5 == 0) {

                System.out.println("Buzz");

            } else {

                System.out.println(num);

            }
            num++;
        }

    }

}
