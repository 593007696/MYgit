package kadai;

import java.text.ParseException;
import java.text.SimpleDateFormat;

public class CommonUtil {
    static boolean isLeapYear(int year) {
        // 日付が妥当が判定する
        String strYear = Integer.toString(year);
        if (!isValidDateString(strYear)) {
            throw new IllegalArgumentException();
        }

        if (year % 4 == 0) {// 西暦年号が4で割り切れる年をうるう年とする。
            return true;

        } else if ((year % 100 == 0) && (year % 400 != 0)) {// 西暦年号が100で割り切れて400で割り切れない年は平年とする。
            return true;
        }
        return false;

    }

    static boolean isValidDateString(String date) {
        // 日付を文字列("")で受け取る、妥当な日付であれば、それ以外false
        SimpleDateFormat format = new SimpleDateFormat("yyyy");
        try {
            format.setLenient(false);// 厳しくチェック日付
            format.parse(date);// 日付型変換
        } catch (ParseException e) {
            return false;
        }

        return true;
    }
}
