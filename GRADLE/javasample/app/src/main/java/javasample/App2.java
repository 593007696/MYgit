package javasample;

public class App2 {
    public static void main(String[] args) {
        System.out.println("Input your Name.");
        java.util.Scanner sc = new java.util.Scanner(System.in);
        String string = sc.next();
        sc.close();
        System.out.println("Hello " + string + "!");
    }
}
