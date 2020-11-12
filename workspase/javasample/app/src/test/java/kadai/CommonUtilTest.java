package kadai;

import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

public class CommonUtilTest {

    @Test
    void testIsLeapYear() {
        assertTrue(CommonUtil.isLeapYear(20200101));

    }

}
