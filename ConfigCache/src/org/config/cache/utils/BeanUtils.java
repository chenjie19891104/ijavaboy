package org.config.cache.utils;

import java.beans.BeanInfo;
import java.beans.IntrospectionException;
import java.beans.Introspector;
import java.beans.PropertyDescriptor;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.Arrays;
import java.util.List;

import org.config.cache.decode.json.DefaultJsonDecoder.Entry;
import org.config.cache.exception.SimpleConfigException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;


/**
 * 创建实体类的工具类
 * @author chenjie
 * 2012-12-10
 */
public final class BeanUtils {
	private static final Logger logger = LoggerFactory.getLogger(BeanUtils.class);
	
	public static final int PROPERTY_NOT_FOUND = -1;

	/**
	 * 创建一个Bean
	 * 
	 * values为bean中每个属性名称-->值的映射
	 * @param clazz
	 * @param values
	 * @return
	 * @throws SimpleConfigException
	 */
	public static <T> T createBean(Class<T> clazz, List<Entry> values) throws SimpleConfigException{
		
		try {
			PropertyDescriptor[] props = getPropertyDescriptor(clazz);
			
			if(values == null || props == null){
				logger.error("createBean failed, The values is null or the props is null");
				return null;
			}
			
			T bean = clazz.newInstance();
			
			Integer[] maps = mapIndex(values, props);
			
			for(int i=0; i<values.size(); i++){
				
				int propIndex = maps[i];
				Entry entry = values.get(i);
				if(propIndex == PROPERTY_NOT_FOUND){
					logger.warn(String.format("%s not found in the class %s", entry.getKey(), clazz.getName()));
					continue;
				}
				
				callSetter(bean, props[propIndex], entry.getValue());
			}
			
			return bean;
			
		} catch (SimpleConfigException e) {
			throw new SimpleConfigException(e);
		} catch (InstantiationException e) {
			throw new SimpleConfigException(e);
		} catch (IllegalAccessException e) {
			throw new SimpleConfigException(e);
		}
		
		
		
		
	}
	
	/**
	 * 将entries中的属性和props进行位置上的一一映射
	 * @param entries
	 * @param props
	 * @return
	 */
	private static Integer[] mapIndex(List<Entry> entries, PropertyDescriptor[] props){
		Integer[] maps = new Integer[entries.size()];
		
		Arrays.fill(maps, PROPERTY_NOT_FOUND);
		
		for(int i=0; i<entries.size(); i++){
			Entry entry = entries.get(i);
			
			for(int j=0; j<props.length; j++){
				PropertyDescriptor prop = props[j];
				
				if(entry.getKey().equalsIgnoreCase(prop.getName())){
					
					maps[i] = j;
					break;
				}
			}
			
		}
		
		return maps;
	}
	
	/**
	 * 调用bean的setter方法
	 * @param bean
	 * @param prop
	 * @param value
	 * @throws SimpleConfigException
	 */
	private static void callSetter(Object bean, PropertyDescriptor prop, String value) throws SimpleConfigException{
		Method setter = prop.getWriteMethod();
		if(setter == null){
			logger.warn(String.format("The prop %s has no setter method", prop.getName()));
			return;
		}
		Class<?>[] params = setter.getParameterTypes();
		Class<?> paramType = params[0];  //取第一个
		
		String val = null;
		
		if(!StringUtils.isEmpty(value)){
			
			val = value;
		}
		
		Object vObj = stringToType(paramType, val);
		try {
			setter.invoke(bean, vObj);
		} catch (IllegalAccessException e) {
			throw new SimpleConfigException(e);
		} catch (IllegalArgumentException e) {
			throw new SimpleConfigException(e);
		} catch (InvocationTargetException e) {
			throw new SimpleConfigException(e);
		}
		
		
	}
	
	/**
	 * 获取指定类的属性描述符
	 * @param clazz
	 * @return
	 * @throws SimpleConfigException 
	 * @throws IntrospectionException
	 */
	public static PropertyDescriptor[] getPropertyDescriptor(Class<?> clazz) throws SimpleConfigException{
		
		
		try {
			BeanInfo info = Introspector.getBeanInfo(clazz);
			info.getPropertyDescriptors();
			PropertyDescriptor props[] = info.getPropertyDescriptors();
			
			for(PropertyDescriptor p : props){
				System.out.println(p.getName());
			}
			
			return props;
		} catch (IntrospectionException e) {
			throw new SimpleConfigException(e);
		}
		
	}
	
	/**
	 * 将String类型的值转换为对应其他类型的值
	 * 
	 * 支持int、long、float、double
	 * @param paramType
	 * @param value
	 * @return
	 */
	private static Object stringToType(Class<?> paramType, String value){
		
		if(value == null){
			return null;
		}
		
		if(paramType.equals(Integer.TYPE) || paramType == Integer.class){
			return StringUtils.toInt(value);
		}else if(paramType.equals(Long.TYPE) || paramType == Long.class){
			return StringUtils.toLong(value);
		}else if(paramType.equals(Float.TYPE) || paramType == Float.class){
			return StringUtils.toFloat(value);
		}else if(paramType.equals(Double.TYPE) || paramType == Double.class){
			return StringUtils.toDouble(value);
		}else {
			return value;
		}
	}
}
