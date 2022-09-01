import java.io.*;
import java.util.Scanner;

public class ExcelImport {

    //requires 2 arguments.
    //first is path to excel file
    //second is int describing what table has been input (see ImportTypes)
    public static int main(String args[]) {
        
        ImportType i;
        try { i = ImportType.values()[Integer.parseInt(args[1])]; }
        catch (NumberFormatException e) {
            System.out.println("Invalid argument 1. Not in range");
            return -1;
        }
        
        Scanner csv;
        try { csv = new Scanner(new File(args[0])); }
        catch (FileNotFoundException e) {
            System.out.println("Invalid argument 0. File not found");
            return -1;
        }

        switch(i) {
            case NULL:
                System.out.println("Import type cannot be 0");
                return -1;
            case STUDENTS:
                importStudents(csv);
                break;
        }

        return 0;

    }

    private static void importStudents(Scanner csv) {

    }

}