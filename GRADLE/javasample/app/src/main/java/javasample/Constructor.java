package javasample;

public class Constructor {

    private String name;

    public Constructor(String name) {
        this.name = name;
    }

    public void hello() {
        System.out.println("hello " + name);
    }

}
