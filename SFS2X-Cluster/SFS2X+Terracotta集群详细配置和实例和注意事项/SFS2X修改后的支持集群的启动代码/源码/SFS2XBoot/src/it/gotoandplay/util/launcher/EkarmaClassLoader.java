package it.gotoandplay.util.launcher;

import java.lang.reflect.Method;
import java.net.URL;
import java.net.URLClassLoader;

import com.tc.object.loaders.NamedClassLoader;

/**
 * 自定义一个ClassLoader,实现NamedClassLoader接口
 * 
 * 这样,让每个负责加载Extension的ClassLoader,都拥有一个名称
 * 这样,集群中的就可以了
 * @author 陈杰
 *
 */
public class EkarmaClassLoader extends URLClassLoader implements NamedClassLoader{
	
	private static final String NAME = "EkarmaClassLoader";
	
	private String loaderName;
	
	public EkarmaClassLoader(URL[] classpath, ClassLoader parent) {
		super(classpath, parent);

		try {
			ClassLoader parentLoader = EkarmaClassLoader.class.getClassLoader();
            Class<?> namedClassLoader = parentLoader.loadClass("com.tc.object.loaders.NamedClassLoader");
            
            Class<?> helper = parentLoader.loadClass("com.tc.object.bytecode.hook.impl.ClassProcessorHelper");
            Method m = helper.getMethod("registerGlobalLoader", new Class[] { namedClassLoader }); 
            
            m.invoke(null, new Object[] { this });
            
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		System.out.println("实例化了一个EkarmaClassLoader");
	}

	public String __tc_getClassLoaderName() {
		
		return NAME;
	}

	@Override
	public void __tc_setClassLoaderName(String arg0) {
		
		this.loaderName = arg0;
	}

}
