package javasample;

public class StringBuilderSpeedTest {
    public static void main(String[] args) {
        long time1 = System.currentTimeMillis();
        StringBuilder sb = new StringBuilder();
        for (int i = 0; i < 10000; i++) {
            sb.append(i);
        }

        long time2 = System.currentTimeMillis();
        System.out.println((time2 - time1) + "msec");

        long time3 = System.currentTimeMillis();
        String s = "";
        for (int i = 0; i < 10000; i++) {
            // s += i; //a
            s = s + i;// b
        }
        long time4 = System.currentTimeMillis();

        System.out.println((time4 - time3) + "msec");
    }
}
