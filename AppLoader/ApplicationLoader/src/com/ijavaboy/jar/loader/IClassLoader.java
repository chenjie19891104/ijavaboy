package com.ijavaboy.jar.loader;

/**
 * @author ijavaboy
 * @site <url>http://www.ijavaboy.com</url>
 * 2013-5-10
 */
public interface IClassLoader {

	/**
	 * Create a new class loader for all the jar files in the specified folder or folders
	 * @param parentClassLoader
	 * @param paths
	 * @return
	 */
	public ClassLoader createClassLoader(ClassLoader parentClassLoader, String...paths);
	
}
