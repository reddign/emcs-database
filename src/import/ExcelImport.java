import java.io.*;
import java.io.BufferedReader;  
import java.io.FileReader;  

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
        
        BufferedReader csv;
        try { csv = new BufferedReader(new FileReader(args[0])); }
        catch (FileNotFoundException e) {
            System.out.println("Invalid argument 0. File not found");
            return -1;
        }

        try {
            switch(i) {
                case NULL:
                    System.out.println("Import type cannot be 0");
                    break;
                case STUDENTS:
                    importStudents(csv);
                    break;
            }
        } catch (IOException e) { System.out.println("error occured while reading file"); }

        try { csv.close(); }
        catch (IOException e) { return -1; }

        return 0;

    }

    private static void importStudents(BufferedReader csv) throws IOException {
        
        String line;
        int year;
        boolean alumn;

        while ((line = csv.readLine()) != null) {
            String[] entry = line.split(",");
            year = gradYeartoInt(entry[2]);
            alumn = yntoBool(entry[3]);
        }

    }

    private static int gradYeartoInt(String s) {
        try { return Integer.parseInt(s); }
        catch (NumberFormatException e) { return -1; }
    }

    private static boolean yntoBool(String s) {
        return s.equals("Yes");
    }

}