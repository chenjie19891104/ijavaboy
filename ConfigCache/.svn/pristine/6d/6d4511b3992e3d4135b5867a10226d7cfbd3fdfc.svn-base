package org.config.cache.data;

import org.config.cache.StringArray;
import org.config.cache.core.IConfig;
import org.config.cache.utils.StringUtils;

/**
 * 怪物组配置表
 * @author chenjie
 * 2012-12-13
 */
public class MonsterGroupConfig implements IConfig {
	public static final int MONSTER_GROUP_NUM = 10;
	
	private Integer id; //ID
	
	private Integer[] soldiers; //士兵
	private Integer[] soldierNums; //士兵数量
	private Integer[] heros; //英雄
	private Integer[] heroLevels; //英雄等级
	private Integer dropID; //掉落ID
	
	@Override
	public void fromStringArray(StringArray values) {
		
		id = values.getInt();
		
		soldiers = new Integer[MONSTER_GROUP_NUM];
		soldierNums = new Integer[MONSTER_GROUP_NUM];
		heros = new Integer[MONSTER_GROUP_NUM];
		heroLevels = new Integer[MONSTER_GROUP_NUM];
		
		for(int i=0; i<MONSTER_GROUP_NUM; i++){
			soldiers[i] = values.getInt();
			soldierNums[i] = values.getInt();
			heros[i] = values.getInt();
			heroLevels[i] = values.getInt();
		}
		
		dropID = values.getInt();
		
	}

	@Override
	public String getKey() {

		return id+"";
	}

	public final Integer getId() {
		return id;
	}

	public final void setId(Integer id) {
		this.id = id;
	}

	public final Integer[] getSoldiers() {
		return soldiers;
	}

	public final void setSoldiers(Integer[] soldiers) {
		this.soldiers = soldiers;
	}

	public final Integer[] getSoldierNums() {
		return soldierNums;
	}

	public final void setSoldierNums(Integer[] soldierNums) {
		this.soldierNums = soldierNums;
	}

	public final Integer[] getHeros() {
		return heros;
	}

	public final void setHeros(Integer[] heros) {
		this.heros = heros;
	}

	public final Integer[] getHeroLevels() {
		return heroLevels;
	}

	public final void setHeroLevels(Integer[] heroLevels) {
		this.heroLevels = heroLevels;
	}

	public final Integer getDropID() {
		return dropID;
	}

	public final void setDropID(Integer dropID) {
		this.dropID = dropID;
	}

	public String toString(){
		
		return StringUtils.toString(getClass(), this);
	}
	
}
