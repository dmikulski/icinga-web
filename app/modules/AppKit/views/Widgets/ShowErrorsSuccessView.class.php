<?php

class AppKit_Widgets_ShowErrorsSuccessView extends ICINGAAppKitBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		$this->setAttribute('title', 'Widgets.ShowErrors');
		
		$aggregator = $this->getContext()->getModel('MessageQueueAggregator', 'AppKit');
		$this->setAttribute('message_items', $aggregator->getMessageItems());
		
		return true;
	}
}

?>