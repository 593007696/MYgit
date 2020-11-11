package drill;

public class Puppy {
    /********************************************* */
    // String breed;// ?種類
    // int size;// !大きさ
    // String colour;// *色
    // int age;// todo年齢

    // void eat() {

    // }

    // void run() {

    // }

    // void sleep() {

    // }

    // void name() {

    // }
    /********************************************* */
    int puppyAge;

    public Puppy(String name) {
        System.out.println("name is " + name);
    }

    public void SetAge(int age) {
        puppyAge = age;
    }

    public int GetAge() {
        System.out.println("age is " + puppyAge);
        return puppyAge;
    }

    public static void main(String[] args) {

        Puppy myPuppy = new Puppy("tommy");// オブジェクト作成

        myPuppy.SetAge(2);
        myPuppy.GetAge();// メソッド引く

        System.out.println(myPuppy.puppyAge + " is age");// メソッドの変数引き出す
    }

}
