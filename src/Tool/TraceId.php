<?php


namespace AF\Tool;


use AF\Constants\ExceptionCode;
use AF\Exception\FrameException;

class TraceId extends BaseTool
{
    private $types = ['Datetime', 'SnowFlake'];

    public function genTraceId(string $type)
    {
        if (!in_array($type, $this->types)) {
            throw new FrameException(ExceptionCode::TRACE_TYPE_ERROR);
        }
        $fun = 'genTraceId' . $type;
        return $this->$fun();
    }

    public function genTraceIdDatetime()
    {
        $dateTime = date('ymdHis');
        $dateTime .= (string)rand(1000, 9999);
        return $dateTime;
    }

    public function genTraceIdSnowFlake()
    {
        return SnowFlake::getInstance()->id();
    }

    /**
     *  TraceId is a header attribute value also an unique identify.
     * when a series requests happen we should confirm which step is wrong, or we need to know what happened in that
     * so we should sign the request.
     * traceId contains three parts.
     * 1. traceId. created by the first request sender.
     * 2. trace steps. added by receiver. step is 1.
     * 3. time string. use format Y-m-d H:i:s
     * @param string $traceId
     * @return string
     */
    public function nextTraceId(string $traceId)
    {
        if (empty($traceId)) {
            return $traceId;
        }
        $traceIdArr = explode('_', $traceId);
        $realTraceId = $traceIdArr[0];
        $steps = 0;
        $time = date('Y-m-d H:i:s');
        if (count($traceIdArr) > 1) {
            $steps = $traceIdArr[1] + 1;
        }
        return implode('_', [$realTraceId, $steps, $time]);
    }
}