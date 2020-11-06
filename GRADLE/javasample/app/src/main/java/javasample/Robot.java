package javasample;

public class Robot {
    private String name;

    public void sayHello() {
        System.out.println("I'm " + name);

    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
}
