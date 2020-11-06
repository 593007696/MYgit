package javasample;

public class UseRobot {
    public static void main(String[] args) {
        Robot robot = new Robot();
        Robot robot2 = robot;
        robot.setName("aaa");
        robot2.setName("bbb");
        robot.sayHello();
        robot2.sayHello();

    }

}
