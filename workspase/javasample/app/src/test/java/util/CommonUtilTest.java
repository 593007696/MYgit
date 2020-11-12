package util;

import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

public class CommonUtilTest {

    @Test
    void testGetTaxRate() {

        assertEquals(10, CommonUtil.getTaxRate("20201013"));
        assertEquals(10, CommonUtil.getTaxRate("20191001"));
        assertEquals(8, CommonUtil.getTaxRate("20190930"));

        assertEquals(8, CommonUtil.getTaxRate("20140401"));
        assertEquals(5, CommonUtil.getTaxRate("20140331"));

        assertEquals(5, CommonUtil.getTaxRate("19970401"));
        assertEquals(3, CommonUtil.getTaxRate("19970331"));

        assertEquals(3, CommonUtil.getTaxRate("19890401"));
        assertEquals(0, CommonUtil.getTaxRate("19890331"));

    }

    @Test
    void testGetTaxRateThrowException() {
        assertThrows(IllegalArgumentException.class, () -> CommonUtil.getTaxRate(""));

    }

    @Test
    void testIsValidDateString() {
        assertTrue(CommonUtil.isValidDateString("20201103"));

        assertFalse(CommonUtil.isValidDateString(""));
        assertFalse(CommonUtil.isValidDateString("20190228"));
    }

}
