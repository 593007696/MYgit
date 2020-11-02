package javasample;

public class WhileSample {
    public static void main(String[] args) {
        int[] array = { 1, 2, 3, 4, 5, 6 };
        int sum = 0;
        int i = 0;
        while (i < array.length) {
            sum = sum + array[i];
            i++;
        }
        System.out.println(sum);
    }

}
