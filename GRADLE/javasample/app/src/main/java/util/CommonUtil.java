package util;

import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;

public class CommonUtil {
    public static int getTaxRate(String date) {
        // 日付を文字列で受け取り 消費税率をIntで返すメソッド

        // 日付が妥当が判定する
        if (!isValidDateString(date)) {
            throw new IllegalArgumentException();
        }

        // 消費税率判定する
        // 10％ 2019/10/01
        if ("20191001".compareTo(date) <= 0) {
            return 10;

        }
        // 8% 2014/04/01
        if ("20140401".compareTo(date) <= 0) {
            return 8;
        }

        // 5% 1997/04/01
        if ("19970401".compareTo(date) <= 0) {
            return 5;
        }

        // 3% 1989/04/01
        if ("19890401".compareTo(date) <= 0) {
            return 3;
        }

        return 0;
    }

    static boolean isValidDateString(String date) {
        // 日付を文字列(yyyymmdd)で受け取る、妥当な日付であれば、それ以外false
        try {
            DateFormat df = new SimpleDateFormat("yyyyMMdd");
            df.setLenient(false);
            String formattedDate = df.format(df.parse(date));
            if (!formattedDate.equals(date)) {
                return false;
            }
        } catch (ParseException e) {
            return false;
        }

        return true;
    }

}
