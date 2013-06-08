package org.config.cache.data;

import org.config.cache.StringArray;
import org.config.cache.core.IConfig;

/**
 * 物品扩展配置表
 * @author zhangchun
 * 2012-12-12
 */
public class ItemExtendConfig implements IConfig {
	
	private Integer id; //物品扩展ID
	private String name; //名称
	private Integer strength; //武力
	private Integer intelligence; //智力
	private Integer command; //统御力
	
	
	@Override
	public void fromStringArray(StringArray values) {
		
		this.id = values.getInt();
		this.name = values.getString();
		this.strength =values.getInt();
		this.intelligence =values.getInt();
		this.command =values.getInt();
		
	}

	@Override
	public String getKey() {

		return this.id+"";
	}
	
	
	public final String getName() {
		return name;
	}

	public final void setName(String name) {
		this.name = name;
	}

	public final Integer getStrength() {
		return strength;
	}

	public final void setStrength(Integer strength) {
		this.strength = strength;
	}

	public final Integer getIntelligence() {
		return intelligence;
	}

	public final void setIntelligence(Integer intelligence) {
		this.intelligence = intelligence;
	}

	

	public final Integer getCommand() {
		return command;
	}

	public final void setCommand(Integer command) {
		this.command = command;
	}

	public final void setId(Integer id) {
		this.id = id;
	}
	
	

	public final Integer getId() {
		return id;
	}

	@Override
	public String toString(){
		
		return this.id+"";
	}

}
