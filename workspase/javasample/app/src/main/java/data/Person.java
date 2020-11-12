package data;

public class Person extends Object {
    String name;
    int age;
    int num;

    public Person(String name, int age, int num) {
        this.name = name;
        this.age = age;
        this.num = num;
    }

    public void greet() {
        System.out.println("Hello!my name" + this.name + "!!");
    }

}
