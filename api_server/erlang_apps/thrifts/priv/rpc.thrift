namespace * rpc

struct Message {
  1:  i64 id,
  2:  string text
}

service RpcService {
  Message call(1: Message m)
}