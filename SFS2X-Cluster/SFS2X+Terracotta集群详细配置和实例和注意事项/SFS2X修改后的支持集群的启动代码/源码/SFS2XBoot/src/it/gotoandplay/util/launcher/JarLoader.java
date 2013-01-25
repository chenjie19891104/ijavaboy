package it.gotoandplay.util.launcher;
 
import java.io.File;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLClassLoader;
import java.util.ArrayList;
import java.util.List;
 
public final class JarLoader implements IClassLoader
 {
   
	public ClassLoader loadClasses(String[] paths, ClassLoader parentClassLoader) throws BootException{
     ClassLoader jarClassLoader = null;
     List<URL> locations = new ArrayList<URL>();
     List<String> jarFiles;
     for (String folder : paths)
     {
       jarFiles = JarFilesUtil.scanFolderForJarFiles(folder);
 
       for (String jarFilePath : jarFiles)
       {
         try
         {
           File jarFile = new File(jarFilePath);
           locations.add(jarFile.toURI().toURL());
         }
         catch (MalformedURLException e)
         {
           throw new BootException("Malformed URL: " + jarFilePath);
         }
       }
 
       if (locations.size() == 0) {
         throw new BootException("Unexpected: no jars were located!");
       }
     }
 
     URL[] classPath = new URL[locations.size()];
     locations.toArray(classPath);
 
     if (Boot.isDebug())
     {
       for (URL item : classPath) {
         System.out.println("Adding to classpath: " + item);
       }
     }
     //changed by chenjie
     //jarClassLoader = new URLClassLoader(classPath, parentClassLoader);
     boolean hasInsted = false;
     if(classPath.length > 0){
    	 String generatedClassLoaderName = generateClassLoaderName(classPath[0]);
    	 
    	 //对我们的扩展使用自定义的EkarmaClassLoader加载
    	 if(generatedClassLoaderName != null && "cluster".equalsIgnoreCase(generatedClassLoaderName)){
    		 jarClassLoader = new EkarmaClassLoader(classPath, parentClassLoader); 
    		 hasInsted = true;
    	 }
    	 
     }
     
     if(!hasInsted){
    	 jarClassLoader = new URLClassLoader(classPath, parentClassLoader); 
     }
     
     //jarClassLoader = new EkarmaClassLoader(classPath, parentClassLoader);
	 		 
     return jarClassLoader;
   }
	
   /**
    * 根据path中的路径信息来提取扩展的名称,再以扩展的名称来命名ClassLoader
    * 
    * @param path
    * @return
    */
   public String generateClassLoaderName(URL urlPath){
	   String path = urlPath.toString();
	   if(path.contains("extensions")){
		   String subPath = path.substring(0,path.lastIndexOf("/"));
		   System.out.println("subPath:"+subPath);
		   
		   String name = subPath.substring(subPath.lastIndexOf("/")+1);
		   
		   System.out.println("generated class loader name:"+name);
		   
		   return name;
	   }
	   return null;
   }

 }
