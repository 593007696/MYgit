package data;

public class Employee extends Person implements Comparable<Employee> {
    int salary;
 

    public Employee(String name, int age, int num) {

        super(name, age, num);
    }

    public void SetSalary(int salary) {
        if (salary <= 0) {
            throw new IllegalArgumentException("できません");

        }
        this.salary = salary;
    }

    public void SetNum(int num) {
        this.num = num;
    }

    @Override
    public int compareTo(Employee o) {

        // return this.name.compareTo(o.name);
        // return Integer.compare(this.age, o.age);
        return Integer.compare(this.num, o.num);

    }
}
