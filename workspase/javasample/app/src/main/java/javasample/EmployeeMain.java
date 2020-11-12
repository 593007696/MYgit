package javasample;

import java.util.*;
import data.Employee;

public class EmployeeMain {
    public static void main(String[] args) {
        ArrayList<Employee> list = new ArrayList<>();

        list.add(new Employee("A", 35, 1111));
        list.add(new Employee("B", 11, 1110));
        list.add(new Employee("C", 20, 1113));

        Collections.sort(list);

        for (int i = 0; i < list.size(); i++) {
            list.get(i).greet();

        }

    }

}
