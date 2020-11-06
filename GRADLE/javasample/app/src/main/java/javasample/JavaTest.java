package javasample;

public class JavaTest {

    public static void main(String[] args) {
        System.out.println("メインメソッド");
        test();

    }

    public static void sample() {
        System.out.println("sampleメソッド");
    }

    public static void test() {
        System.out.println("testメソッド");
        sample();

    }
}

// ! 红色的高亮注释
// ? 蓝色的高亮注释
// * 绿色的高亮注释
// todo 橙色的高亮注释
// // 灰色带删除线的注释
// 普通的注释
