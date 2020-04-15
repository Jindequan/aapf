<?php

namespace AF\InterfaceCenter;

/**
 * 事件处理要严格按照步骤前进，以保证代码处理的界限，权责分明，尽量减少耦合性
 * 步骤包括但不限于以下四个
 * Interface eventFlow
 * @package APF\InterfaceCenter
 */
interface EventFlow
{
    /**
     * 事件处理者
     * 依据内外部参数等信息选择事件的处理者
     * @return mixed
     */
    public function eventProcessor();

    /**
     * 事件派发
     * 划定事件处理者，将任务派发给处理者，将消息通知事件关联方（流程相关者）
     * @return mixed
     */
    public function eventDispatch();

    /**
     * 事件执行
     * 处理者执行任务
     * @return mixed
     */
    public function eventExecute();

    /**
     * 事件完结
     * 处理完毕之后，告知事件发起方处理结果，并通知事件相关者
     * @return mixed
     */
    public function eventFinish();
}