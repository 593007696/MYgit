package javasample;

public class App2 {
    public static void main(String[] args) {
        System.out.println("Input your Name.");
        java.util.Scanner sc = new java.util.Scanner(System.in);
        String string = sc.next();
        sc.close();
        System.out.println("Hello " + string + "!");
        int a = 10;
        int b = a++;
        int c = +a;
        int d = a++;
        int e = a;
        System.out.println(b);
        System.out.println(c);
        System.out.println(d);
        System.out.println(e);
    }
}
