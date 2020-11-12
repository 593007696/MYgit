package javasample;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

public class FileReadTest {
    public static void main(String[] args) throws IOException {
        File files = new File("C:\\web\\tst.txt");
        FileReader file = new FileReader(files);
        BufferedReader br = new BufferedReader(file);
        String line = null;
        try (br) {
            while ((line = br.readLine()) != null) {

                System.out.println(line);

            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

}
