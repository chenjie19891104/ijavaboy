package org.config.cache.data;

import org.config.cache.StringArray;
import org.config.cache.core.IConfig;
import org.config.cache.utils.StringUtils;

/**
 * 任务配置表
 * @author chenjie
 * 2012-12-12
 */
public class MissionConfig implements IConfig {
	
	public static final int TRIGGER_NUM = 3; //触发条件最大数量
	public static final int SUB_MODE_NUM = 4; //任务子模式最大数量
	public static final int REWARD_ITEM_NUM = 5; //奖励物品最大数量
	
	private Integer id; //任务ID
	private String name; //任务名称
	private Integer type; //任务类型
	private Integer rootTaskID; //根任务ID
	private Integer nextTaskID; //下一个任务ID
	private Integer minLevel; //最小等级
	private Integer maxLevel; //最大等级
	
	//触发条件
	private Integer triggerConditionNum; //触发条件数量
	private Integer[] triggerTypes; //触发类型
	private Integer[] triggerData; //触发数值
	
	//完成条件
	private Integer completeModeNum; //需要完成前n个子模式任务
	private Integer[] subModes; //子模式
	private Integer[] subTypes; //子类型
	private Integer[] subCompletes; //完成选项
	
	//奖励
	private Integer experience; //奖励经验
	private Integer money; //奖励铜钱
	private Boolean random; //是否随机奖励
	private Integer selectedItemNum; //可以选择的奖励物品数量
	private Integer[] rewardItems; //奖励的物品
	private Integer[] rewardItemNums; //奖励的物品数量
	
	private String desc; //任务描述
	
	
	@Override
	public void fromStringArray(StringArray values) {
		
		this.id = values.getInt();
		this.name = values.getString();
		this.type = values.getInt();
		this.rootTaskID = values.getInt();
		this.nextTaskID = values.getInt();
		this.minLevel = values.getInt();
		this.maxLevel = values.getInt();
		
		this.triggerConditionNum = values.getInt();
		
		this.triggerTypes = new Integer[TRIGGER_NUM];
		this.triggerData = new Integer[TRIGGER_NUM];
		for(int i=0; i<TRIGGER_NUM; i++){
			this.triggerTypes[i] = values.getInt();
			this.triggerData[i] = values.getInt();
		}
		
		this.completeModeNum = values.getInt();
		
		this.subModes = new Integer[SUB_MODE_NUM];
		this.subTypes = new Integer[SUB_MODE_NUM];
		this.subCompletes = new Integer[SUB_MODE_NUM];
		
		for(int i=0; i<SUB_MODE_NUM; i++){
			this.subModes[i] = values.getInt();
			this.subTypes[i] = values.getInt();
			this.subCompletes[i] = values.getInt();
		}
		
		this.experience = values.getInt();
		this.money = values.getInt();
		this.random = values.getBool();
		this.selectedItemNum = values.getInt();
		
		this.rewardItems = new Integer[REWARD_ITEM_NUM];
		this.rewardItemNums = new Integer[REWARD_ITEM_NUM];
		
		for(int i=0; i<REWARD_ITEM_NUM; i++){
			this.rewardItems[i] = values.getInt();
			this.rewardItemNums[i] = values.getInt();
		}
		
		this.desc = values.getString();
	}

	@Override
	public String getKey() {

		return this.id+"";
	}

	public final Integer getId() {
		return id;
	}

	public final void setId(Integer id) {
		this.id = id;
	}

	public final String getName() {
		return name;
	}

	public final void setName(String name) {
		this.name = name;
	}

	public final Integer getType() {
		return type;
	}

	public final void setType(Integer type) {
		this.type = type;
	}

	public final Integer getRootTaskID() {
		return rootTaskID;
	}

	public final void setRootTaskID(Integer rootTaskID) {
		this.rootTaskID = rootTaskID;
	}

	public final Integer getNextTaskID() {
		return nextTaskID;
	}

	public final void setNextTaskID(Integer nextTaskID) {
		this.nextTaskID = nextTaskID;
	}

	public final Integer getMinLevel() {
		return minLevel;
	}

	public final void setMinLevel(Integer minLevel) {
		this.minLevel = minLevel;
	}

	public final Integer getMaxLevel() {
		return maxLevel;
	}

	public final void setMaxLevel(Integer maxLevel) {
		this.maxLevel = maxLevel;
	}

	public final Integer getTriggerConditionNum() {
		return triggerConditionNum;
	}

	public final void setTriggerConditionNum(Integer triggerConditionNum) {
		this.triggerConditionNum = triggerConditionNum;
	}

	public final Integer[] getTriggerTypes() {
		return triggerTypes;
	}

	public final void setTriggerTypes(Integer[] triggerTypes) {
		this.triggerTypes = triggerTypes;
	}

	public final Integer[] getTriggerData() {
		return triggerData;
	}

	public final void setTriggerData(Integer[] triggerData) {
		this.triggerData = triggerData;
	}

	public final Integer getCompleteModeNum() {
		return completeModeNum;
	}

	public final void setCompleteModeNum(Integer completeModeNum) {
		this.completeModeNum = completeModeNum;
	}

	public final Integer[] getSubModes() {
		return subModes;
	}

	public final void setSubModes(Integer[] subModes) {
		this.subModes = subModes;
	}

	public final Integer[] getSubTypes() {
		return subTypes;
	}

	public final void setSubTypes(Integer[] subTypes) {
		this.subTypes = subTypes;
	}

	public final Integer[] getSubCompletes() {
		return subCompletes;
	}

	public final void setSubCompletes(Integer[] subCompletes) {
		this.subCompletes = subCompletes;
	}

	public final Integer getExperience() {
		return experience;
	}

	public final void setExperience(Integer experience) {
		this.experience = experience;
	}

	public final Integer getMoney() {
		return money;
	}

	public final void setMoney(Integer money) {
		this.money = money;
	}

	public final Boolean getRandom() {
		return random;
	}

	public final void setRandom(Boolean random) {
		this.random = random;
	}

	public final Integer getSelectedItemNum() {
		return selectedItemNum;
	}

	public final void setSelectedItemNum(Integer selectedItemNum) {
		this.selectedItemNum = selectedItemNum;
	}

	public final Integer[] getRewardItems() {
		return rewardItems;
	}

	public final void setRewardItems(Integer[] rewardItems) {
		this.rewardItems = rewardItems;
	}

	public final Integer[] getRewardItemNums() {
		return rewardItemNums;
	}

	public final void setRewardItemNums(Integer[] rewardItemNums) {
		this.rewardItemNums = rewardItemNums;
	}

	public final String getDesc() {
		return desc;
	}

	public final void setDesc(String desc) {
		this.desc = desc;
	}

	public String toString(){
		
		return StringUtils.toString(MissionConfig.class, this);
	}
}
