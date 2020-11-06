package javasample;

public class UseStaticVariable {

    public static void main(String[] args) {
        StaticVariable.num = 10;
        StaticVariable sample = new StaticVariable();
        System.out.println(sample.num);//!ここはインスタンスの参照が入っている変数名.フィールド名
        //!コンパイラがコンパイルする際に　クラス名.メンバー名　の書式に変更してしまいます。
        // todo その為、ここは　 System.out.println(StaticVariable.num);　に置き換わります。
    }
}
