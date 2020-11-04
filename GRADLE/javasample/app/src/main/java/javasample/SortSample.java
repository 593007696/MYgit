package javasample;

import java.util.Arrays;

//import java.util.*; /util全部取り出す

public class SortSample {
    public static void main(String[] args) {
        int[] array = { 6, 2, 4, 9, 1 };
        Arrays.sort(array); // 小さい順
        System.out.println(Arrays.toString(array));
    }

}
