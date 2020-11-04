package javasample;

import java.io.File;
import java.io.PrintWriter;

public class FileWriteTest {
    public static void main(String[] args) {

        try (PrintWriter pw = new PrintWriter(new File("C:\\web\\data.txt"))) {
            pw.println("あああ12122あああああああ");
            pw.flush();
        } catch (Exception e) {
            e.printStackTrace();
        }

    }

}
