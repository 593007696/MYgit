package drill;

import java.text.*;

import java.util.*;

public class DateDemo {
    public static void main(String[] args) {
        boolean tof = compareTime("2018-05-11", "2018-05-12", "yyyy-MM-dd");
        System.out.println(tof);

        Date date = new Date();
        // b的使用，月份简称
        String str = String.format(Locale.US, "英文月份简称：%tb", date);
        System.out.println(str);
        System.out.printf("本地月份简称：%tb%n", date);
        // B的使用，月份全称
        str = String.format(Locale.US, "英文月份全称：%tB", date);
        System.out.println(str);
        System.out.printf("本地月份全称：%tB%n", date);
        // a的使用，星期简称
        str = String.format(Locale.US, "英文星期的简称：%ta", date);
        System.out.println(str);
        // A的使用，星期全称
        System.out.printf("本地星期的简称：%tA%n", date);
        // C的使用，年前两位
        System.out.printf("年的前两位数字（不足两位前面补0）：%tC%n", date);
        // y的使用，年后两位
        System.out.printf("年的后两位数字（不足两位前面补0）：%ty%n", date);
        // j的使用，一年的天数
        System.out.printf("一年中的天数（即年的第几天）：%tj%n", date);
        // m的使用，月份
        System.out.printf("两位数字的月份（不足两位前面补0）：%tm%n", date);
        // d的使用，日（二位，不够补零）
        System.out.printf("两位数字的日（不足两位前面补0）：%td%n", date);
        // e的使用，日（一位不补零）
        System.out.printf("月份的日（前面不补0）：%te%n", date);

        try {
            Date x = new Date();
            System.out.println(x + "\n");
            long start = System.currentTimeMillis();

            Thread.sleep(2000); // 休眠

            Date y = new Date();
            System.out.println(y + "\n");
            long end = System.currentTimeMillis();

            long n = (y.getTime() - x.getTime()) / 1000;
            long diff = end - start;

            System.out.println(n + "秒休眠");
            System.out.println("Difference is : " + diff);

        } catch (Exception e) {
            System.out.println("Got an exception!");
        }

        Calendar c1 = Calendar.getInstance();
        c1.set(2020, 10, 8);//手動日付設定
        // 获得年份
        int year = c1.get(Calendar.YEAR);
        // 获得月份
        int month = c1.get(Calendar.MONTH) + 1;
        // 获得日期
        int date1 = c1.get(Calendar.DATE);
        // 获得小时
        int hour = c1.get(Calendar.HOUR_OF_DAY);
        // 获得分钟
        int minute = c1.get(Calendar.MINUTE);
        // 获得秒
        int second = c1.get(Calendar.SECOND);
        // 获得星期几（注意（这个与Date类是不同的）：1代表星期日、2代表星期1、3代表星期二，以此类推）
        int dayNum = c1.get(Calendar.DAY_OF_WEEK) - 1;

        String[] week = { "日", "月", "火", "水", "木", "金", "土" };
        String day = week[dayNum];

        System.out.println(year + "-" + month + "-" + date1 + "-" + hour + "-" + minute + "-" + second + "-" + day);

    }

    public static boolean compareTime(String time1, String time2, String format) {
        SimpleDateFormat sdf = new SimpleDateFormat(format);
        try {
            Date a = sdf.parse(time1);
            Date b = sdf.parse(time2);
            if (a.before(b)) {
                return true;
            } else {
                return false;
            }

        } catch (ParseException e) {

            e.printStackTrace();
            return false;
        }

    }
}
