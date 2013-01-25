package it.gotoandplay.util.launcher;
 
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;
import java.util.jar.JarEntry;
import java.util.jar.JarFile;
 
 public final class JarFilesUtil
 {
   private static final String JAR_EXT = ".jar";
 
   @SuppressWarnings("unchecked")
	public static List<String> scanFolderForJarFiles(String path)
     throws BootException
   {
     List jarFiles = new ArrayList();
     File theFolder = new File(path);
 
     if (!theFolder.isDirectory()) {
       throw new BootException("The provided path is not a directory: " + path);
     }
     for (File fileEntry : theFolder.listFiles())
     {
       if (!fileEntry.isFile())
         continue;
       String fileName = fileEntry.getName();
 
       if (hasExtension(fileName, ".jar")) {
         jarFiles.add(path + "/" + fileName);
       }
     }
 
     return jarFiles;
   }
 
   @SuppressWarnings("unchecked")
   public static List<String> scanClassNamesInJarFile(String jarFilePath) throws BootException
   {
     List classNames = new ArrayList();
     try
     {
       JarFile jarFile = new JarFile(jarFilePath);
       Enumeration entries = jarFile.entries();
 
       while (entries.hasMoreElements())
       {
         JarEntry entry = (JarEntry)entries.nextElement();
 
         if (entry.isDirectory())
           continue;
         if (!entry.getName().endsWith(".class")) {
           continue;
         }
         String fqcName = entry.getName().replace('/', '.');
 
         classNames.add(fqcName.substring(0, fqcName.length() - 6));
       }
 
     }
     catch (IOException e)
     {
       throw new BootException("Cannot access jar file: " + jarFilePath);
     }
 
     return classNames;
   }
 
   private static boolean hasExtension(String fileName, String expectedExtension)
   {
     boolean isOk = false;
 
     if (fileName == null) {
       return isOk;
     }
 
     int extPos = fileName.lastIndexOf('.');
 
     if (extPos > 0)
     {
       String fileExt = fileName.substring(extPos);
       if (expectedExtension.equalsIgnoreCase(fileExt)) {
         isOk = true;
       }
     }
     return isOk;
   }
}
